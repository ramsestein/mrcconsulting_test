<?php

/**
 * =====================================================================
 *  Funciones de ayuda para las plantillas y snippets.
 *  Todas empiezan por «mrc_» para distinguirlas de las de Kirby.
 * =====================================================================
 */

use Kirby\Cms\File;
use Kirby\Cms\Html;
use Kirby\Content\Field;
use Kirby\Toolkit\Str;

/**
 * ¿Estamos generando la vista previa estática (GitHub Pages)?
 */
function mrc_is_preview(): bool
{
	return option('mrc.preview', false) === true;
}

/**
 * Dirección de un archivo de assets/ con su fecha de modificación
 * (?v=…) para que el navegador descargue la versión nueva tras un cambio.
 *
 *   mrc_asset('css/01-tokens.css') → https://…/assets/css/01-tokens.css?v=1731940000
 */
function mrc_asset(string $path): string
{
	$file    = kirby()->root('index') . '/assets/' . $path;
	$version = is_file($file) ? filemtime($file) : time();

	return url('assets/' . $path) . '?v=' . $version;
}

/**
 * Convierte un campo de tipo «link» del panel en una dirección completa.
 *
 * @param Field       $link   Campo link (página, url, email, teléfono, ancla)
 * @param string|null $anchor Sección de destino opcional (#ancla)
 * @param string|null $topic  Tema a preseleccionar en el formulario (?topic=)
 */
function mrc_link(Field $link, ?string $anchor = null, ?string $topic = null): ?string
{
	$url = $link->toUrl();

	if ($url === null) {
		return null;
	}

	if (empty($topic) === false) {
		$url .= (str_contains($url, '?') ? '&' : '?') . 'topic=' . rawurlencode($topic);
	}

	if (empty($anchor) === false) {
		$url .= '#' . Str::slug($anchor);
	}

	return $url;
}

/**
 * ¿El enlace apunta a la página que se está viendo? (para marcar el menú)
 */
function mrc_is_active(Field $link): bool
{
	$target = $link->toPage();
	$page   = page();

	if ($target === null || $page === null) {
		return false;
	}

	return $target->is($page) || ($target->isHomePage() === false && $page->isDescendantOf($target));
}

/**
 * Etiqueta <img> adaptable: genera versiones WebP de varios tamaños y el
 * navegador elige la adecuada. Usar siempre esto para imágenes de contenido.
 *
 * @param File|null $file    Imagen
 * @param string    $sizes   Ancho que ocupará en pantalla (atributo sizes)
 * @param string    $srcset  Preset definido en config.php → thumbs.srcsets
 * @param array     $attrs   Atributos extra (class, loading, fetchpriority…)
 */
function mrc_img(?File $file, string $sizes = '100vw', string $srcset = 'default', array $attrs = []): string
{
	if ($file === null || $file->type() !== 'image') {
		return '';
	}

	// Los SVG no necesitan versiones de tamaño
	if ($file->extension() === 'svg') {
		return Html::img($file->url(), array_merge(['alt' => $file->alt()->value() ?? ''], $attrs));
	}

	$default = $file->thumb(['width' => 1200, 'format' => 'webp']);

	return Html::img($default->url(), array_merge([
		'srcset'   => $file->srcset($srcset),
		'sizes'    => $sizes,
		'width'    => $default->width(),
		'height'   => $default->height(),
		'alt'      => $file->alt()->value() ?? '',
		'loading'  => 'lazy',
		'decoding' => 'async',
	], $attrs));
}

/**
 * Iniciales de un nombre (para las fichas del equipo sin foto).
 *   mrc_initials('Andrea Pascual Herrero') → "AP"
 */
function mrc_initials(string $name): string
{
	$parts = preg_split('/\s+/', trim($name)) ?: [];
	$first = mb_substr($parts[0] ?? '', 0, 1);
	$second = mb_substr($parts[1] ?? '', 0, 1);

	return mb_strtoupper($first . $second);
}
