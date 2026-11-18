<?php
/**
 * Plantilla «Página estándar» (About us, Services, Pricing, páginas legales
 * y cualquier página nueva que se cree en el panel).
 * Campos: site/blueprints/pages/default.yml
 *
 * Si el primer bloque es una «Portada», esta hace de cabecera; si no, se
 * muestra la cabecera estándar con el título y el subtítulo.
 */

$blocks = $page->blocks()->toBlocks();
?>
<?php snippet('layout', slots: true) ?>

	<?php if ($blocks->first()?->type() !== 'hero'): ?>
	<?php snippet('page-header') ?>
	<?php endif ?>

	<?php snippet('blocks', ['blocks' => $blocks]) ?>

<?php endsnippet() ?>
