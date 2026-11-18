<?php
/**
 * Contenido de /sitemap.xml (ruta definida en site/plugins/mrc/index.php).
 * Cada página aparece una vez por idioma, con sus versiones alternativas.
 *
 * @var \Kirby\Cms\Pages     $pages
 * @var \Kirby\Cms\Languages $languages
 */

echo '<?xml version="1.0" encoding="utf-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xhtml="http://www.w3.org/1999/xhtml">
<?php foreach ($pages as $p): ?>
<?php foreach ($languages as $lang): ?>
	<url>
		<loc><?= esc($p->url($lang->code())) ?></loc>
		<lastmod><?= date('Y-m-d', $p->modified()) ?></lastmod>
		<?php foreach ($languages as $alt): ?>
		<xhtml:link rel="alternate" hreflang="<?= $alt->code() ?>" href="<?= esc($p->url($alt->code())) ?>"/>
		<?php endforeach ?>
	</url>
<?php endforeach ?>
<?php endforeach ?>
</urlset>
