<?php
/**
 * Plantilla de la página de inicio. Solo muestra sus bloques (el primero
 * suele ser la «Portada»). Campos: site/blueprints/pages/home.yml
 */
?>
<?php snippet('layout', slots: true) ?>

	<?php snippet('blocks', ['blocks' => $page->blocks()->toBlocks()]) ?>

<?php endsnippet() ?>
