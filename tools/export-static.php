<?php

/**
 * =====================================================================
 *  Genera una COPIA ESTÁTICA de la web (HTML + imágenes + CSS) para la
 *  vista previa en GitHub Pages. SOLO se usa durante el desarrollo.
 * ---------------------------------------------------------------------
 *  La web real (IONOS) NO usa esto: allí Kirby funciona con PHP.
 *
 *  Uso:
 *    php tools/export-static.php --base=https://usuario.github.io/repo --out=_site
 *
 *  Qué hace:
 *    1. Arranca el servidor de PHP en segundo plano en modo «vista previa»
 *       (MRC_PREVIEW=1: formulario desactivado y aviso de no indexar).
 *    2. Lee /sitemap.xml y descarga cada página en ambos idiomas.
 *    3. Descarga los CSS, fuentes e imágenes que usan esas páginas.
 *    4. Cambia las direcciones locales por la dirección de GitHub Pages.
 *    5. Añade index.html (elige idioma), 404.html y robots.txt.
 * =====================================================================
 */

$options = getopt('', ['base:', 'out:', 'port::']);
$base    = rtrim($options['base'] ?? '', '/');
$out     = $options['out'] ?? '_site';
$port    = (int) ($options['port'] ?? 8765);
$root    = dirname(__DIR__);
$local   = "http://127.0.0.1:$port";

if ($base === '') {
	fwrite(STDERR, "Falta --base (p. ej. --base=https://usuario.github.io/repo)\n");
	exit(1);
}

$basePath = rtrim(parse_url($base, PHP_URL_PATH) ?? '', '/');
$out      = str_starts_with($out, '/') || preg_match('/^[A-Z]:/i', $out) ? $out : $root . '/' . $out;

// ---------------------------------------------------------------------
// 1. Servidor local en modo vista previa
// ---------------------------------------------------------------------
$env    = array_merge(getenv(), ['MRC_PREVIEW' => '1']);
// Rutas relativas a la carpeta del proyecto (evita problemas con acentos
// o espacios en la ruta completa, p. ej. en Windows)
$cmd    = [PHP_BINARY, '-S', "127.0.0.1:$port", '-t', '.', 'kirby/router.php'];
// El registro del servidor va a un archivo temporal (con «pipes» se bloquea en Windows)
$log    = sys_get_temp_dir() . '/mrc-export-server.log';
$server = proc_open($cmd, [0 => ['pipe', 'r'], 1 => ['file', $log, 'a'], 2 => ['file', $log, 'a']], $pipes, $root, $env);

if (is_resource($server) === false) {
	fwrite(STDERR, "No se pudo arrancar el servidor de PHP\n");
	exit(1);
}

register_shutdown_function(function () use ($server) {
	proc_terminate($server);
});

/** Descarga una dirección del servidor local: [código HTTP, contenido, tipo] */
function fetch(string $url): array
{
	$context = stream_context_create(['http' => ['ignore_errors' => true, 'timeout' => 60, 'follow_location' => 0]]);
	$body    = @file_get_contents($url, false, $context);
	$status  = 0;
	$type    = '';

	foreach ($http_response_header ?? [] as $header) {
		if (preg_match('#^HTTP/\S+\s+(\d+)#', $header, $m)) {
			$status = (int) $m[1];
		}
		if (stripos($header, 'Content-Type:') === 0) {
			$type = trim(substr($header, 13));
		}
	}

	return [$status, $body === false ? '' : $body, $type];
}

// Esperar a que el servidor responda
for ($i = 0; $i < 50; $i++) {
	if (@fsockopen('127.0.0.1', $port)) {
		break;
	}
	usleep(200000);
}

// ---------------------------------------------------------------------
// Preparar la carpeta de salida
// ---------------------------------------------------------------------
if (is_dir($out)) {
	$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($out, FilesystemIterator::SKIP_DOTS), RecursiveIteratorIterator::CHILD_FIRST);
	foreach ($it as $file) {
		$file->isDir() ? rmdir($file->getPathname()) : unlink($file->getPathname());
	}
}
@mkdir($out, 0777, true);

/** Guarda un archivo en la carpeta de salida respetando su ruta */
function save(string $out, string $path, string $content): void
{
	$file = $out . '/' . ltrim($path, '/');
	@mkdir(dirname($file), 0777, true);
	file_put_contents($file, $content);
}

// ---------------------------------------------------------------------
// 2. Páginas (a partir del sitemap)
// ---------------------------------------------------------------------
[$status, $sitemap] = fetch("$local/sitemap.xml");
if ($status !== 200) {
	fwrite(STDERR, "No se pudo leer sitemap.xml (HTTP $status)\n");
	exit(1);
}

preg_match_all('#<loc>(.*?)</loc>#', $sitemap, $matches);
$pages  = array_unique(array_map('html_entity_decode', $matches[1]));
$assets = [];
$saved  = [];

/** Busca en un HTML todos los archivos locales (assets/ y media/) que usa */
function collectAssets(string $html, string $local): array
{
	$found = [];
	$quoted = preg_quote($local, '#');

	// src="…", href="…", content="…" y cada entrada de srcset="…"
	preg_match_all('#' . $quoted . '/((?:assets|media)/[^"\'\s,)]+)#', $html, $m);
	foreach ($m[1] as $path) {
		$found[] = $path;
	}

	return $found;
}

foreach ($pages as $url) {
	$path = parse_url($url, PHP_URL_PATH) ?: '/';
	[$status, $html] = fetch($local . $path);

	if ($status !== 200) {
		fwrite(STDERR, "  ! $path → HTTP $status\n");
		continue;
	}

	save($out, rtrim($path, '/') . '/index.html', $html);
	$saved[] = rtrim($path, '/') . '/index.html';
	$assets  = array_merge($assets, collectAssets($html, $local));
	echo "  página  $path\n";
}

// Página de error (GitHub Pages muestra 404.html)
[, $html404] = fetch("$local/en/esta-pagina-no-existe");
save($out, '404.html', $html404);
$saved[] = '404.html';
$assets  = array_merge($assets, collectAssets($html404, $local));

// ---------------------------------------------------------------------
// 3. Archivos: CSS, JS, fuentes, imágenes (y lo que piden los CSS)
// ---------------------------------------------------------------------
$queue = array_unique($assets);
$done  = [];

while ($queue) {
	$asset = array_shift($queue);
	$clean = strtok($asset, '?');

	if (isset($done[$clean])) {
		continue;
	}
	$done[$clean] = true;

	[$status, $body] = fetch("$local/$asset");
	if ($status !== 200) {
		fwrite(STDERR, "  ! $asset → HTTP $status\n");
		continue;
	}

	save($out, $clean, $body);

	// Los CSS pueden pedir fuentes e imágenes con url(…) relativas
	if (str_ends_with($clean, '.css')) {
		preg_match_all('#url\(["\']?([^"\')]+)["\']?\)#', $body, $m);
		foreach ($m[1] as $ref) {
			if (str_starts_with($ref, 'data:') || str_contains($ref, '://')) {
				continue;
			}
			$resolved = dirname($clean) . '/' . $ref;
			// normalizar «../»
			$parts = [];
			foreach (explode('/', $resolved) as $part) {
				if ($part === '..') {
					array_pop($parts);
				} elseif ($part !== '.' && $part !== '') {
					$parts[] = $part;
				}
			}
			$queue[] = implode('/', $parts);
		}
	}
}

echo '  archivos: ' . count($done) . "\n";

// ---------------------------------------------------------------------
// 4. Cambiar las direcciones locales por las de GitHub Pages
// ---------------------------------------------------------------------
foreach ($saved as $file) {
	$path = $out . '/' . ltrim($file, '/');
	$html = file_get_contents($path);
	$html = str_replace($local, $base, $html);

	// Enlaces escritos a mano en el panel que empiezan por «/» (p. ej. /es/tarifas)
	if ($basePath !== '') {
		$html = preg_replace('#(href|src)="/(?!/)(?!' . preg_quote(ltrim($basePath, '/'), '#') . '/)#', '$1="' . $basePath . '/', $html);
	}

	file_put_contents($path, $html);
}

// ---------------------------------------------------------------------
// 5. Archivos especiales
// ---------------------------------------------------------------------

// Raíz: elegir idioma según el navegador (en el servidor real lo hace Kirby)
save($out, 'index.html', <<<HTML
<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="robots" content="noindex, nofollow">
	<meta http-equiv="refresh" content="0; url=$base/en">
	<title>MR&amp;C Consulting</title>
	<script>
		var lang = (navigator.language || 'en').toLowerCase().indexOf('es') === 0 ? 'es' : 'en';
		location.replace('$base/' + lang);
	</script>
</head>
<body><a href="$base/en">English</a> · <a href="$base/es">Español</a></body>
</html>
HTML);

[, $robots] = fetch("$local/robots.txt");
save($out, 'robots.txt', $robots);

// Evitar que GitHub Pages procese los archivos con Jekyll
save($out, '.nojekyll', '');

echo "Copia estática generada en: $out\n";
