<?php
/**
 * <head> de todas las páginas: título, textos para Google y redes,
 * idiomas alternativos, iconos, fuentes, estilos y JavaScript.
 *
 * Los textos SEO salen de la pestaña «Google y redes» de cada página
 * (métodos seoTitle/seoDescription/seoImage en site/plugins/mrc/index.php).
 */

$language    = kirby()->language();
$description = $page->seoDescription();
$image       = $page->seoImage();

// Hojas de estilo, en este orden (ver docs/arquitectura.md → CSS)
$styles = [
	'css/01-tokens.css',
	'css/02-base.css',
	'css/03-layout.css',
	'css/04-components.css',
	'css/05-blocks.css',
	'css/06-pages.css',
];
?>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?= esc($page->seoTitle()) ?></title>
	<meta name="description" content="<?= esc($description, 'attr') ?>">
	<?php if (mrc_is_preview()): ?>
	<meta name="robots" content="noindex, nofollow">
	<?php endif ?>

	<!-- Idiomas: la misma página en inglés y en español -->
	<link rel="canonical" href="<?= $page->url() ?>">
	<?php foreach (kirby()->languages() as $lang): ?>
	<link rel="alternate" hreflang="<?= $lang->code() ?>" href="<?= $page->url($lang->code()) ?>">
	<?php endforeach ?>
	<link rel="alternate" hreflang="x-default" href="<?= $page->url(kirby()->defaultLanguage()->code()) ?>">

	<!-- Al compartir en redes sociales -->
	<meta property="og:type" content="<?= $page->intendedTemplate()->name() === 'post' ? 'article' : 'website' ?>">
	<meta property="og:site_name" content="<?= esc($site->title(), 'attr') ?>">
	<meta property="og:title" content="<?= esc($page->metaTitle()->or($page->title()), 'attr') ?>">
	<meta property="og:description" content="<?= esc($description, 'attr') ?>">
	<meta property="og:url" content="<?= $page->url() ?>">
	<meta property="og:locale" content="<?= $language?->code() === 'es' ? 'es_ES' : 'en_GB' ?>">
	<?php if ($image): ?>
	<meta property="og:image" content="<?= $image->thumb(['width' => 1200, 'height' => 630, 'crop' => true, 'format' => 'jpg'])->url() ?>">
	<?php endif ?>
	<meta name="twitter:card" content="summary_large_image">

	<!-- Iconos -->
	<link rel="icon" href="<?= url('assets/img/favicon.svg') ?>" type="image/svg+xml">
	<link rel="icon" href="<?= url('assets/img/favicon-32.png') ?>" sizes="32x32" type="image/png">
	<link rel="apple-touch-icon" href="<?= url('assets/img/apple-touch-icon.png') ?>">
	<meta name="theme-color" content="#106ab1">

	<!-- Fuentes (alojadas en la propia web, sin Google) -->
	<link rel="preload" href="<?= url('assets/fonts/inter-latin-wght-normal.woff2') ?>" as="font" type="font/woff2" crossorigin>
	<link rel="preload" href="<?= url('assets/fonts/montserrat-latin-wght-normal.woff2') ?>" as="font" type="font/woff2" crossorigin>

	<!-- Estilos -->
	<?php foreach ($styles as $style): ?>
	<link rel="stylesheet" href="<?= mrc_asset($style) ?>">
	<?php endforeach ?>

	<!-- JavaScript mínimo: menú del móvil y formulario -->
	<script src="<?= mrc_asset('js/site.js') ?>"></script>

	<!-- Datos estructurados para Google -->
	<script type="application/ld+json"><?= json_encode([
		'@context' => 'https://schema.org',
		'@type'    => 'Organization',
		'name'     => $site->title()->value(),
		'url'      => $site->url(),
		'logo'     => url('assets/img/logo.png'),
		'email'    => $site->email()->value(),
		'sameAs'   => array_values($site->social()->toStructure()->toArray(fn ($item) => $item->url()->value())),
	], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) ?></script>
</head>
