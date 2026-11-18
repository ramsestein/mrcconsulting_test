<?php
/**
 * Muestra los bloques de una página.
 *
 * - Los bloques de «sección» (portada, tarjetas, servicios…) ocupan todo
 *   el ancho y se muestran tal cual.
 * - Los bloques de «texto sencillo» seguidos (título, párrafo, lista,
 *   imagen, cita) se agrupan en una columna de lectura cómoda.
 *
 * Uso: snippet('blocks', ['blocks' => $page->blocks()->toBlocks()])
 *
 * @var \Kirby\Cms\Blocks $blocks
 */

// Tipos de bloque de texto sencillo (ver site/blueprints/fields/blocks.yml)
$textTypes = ['heading', 'text', 'list', 'image', 'quote', 'gallery'];

$buffer = [];

// Imprime el grupo de bloques de texto acumulado
$flush = function () use (&$buffer) {
	if (count($buffer) === 0) {
		return;
	}
	echo '<div class="block block--prose"><div class="container container--narrow prose">';
	foreach ($buffer as $textBlock) {
		echo $textBlock;
	}
	echo '</div></div>';
	$buffer = [];
};

foreach ($blocks as $block) {
	if (in_array($block->type(), $textTypes, true)) {
		$buffer[] = $block;
		continue;
	}

	$flush();
	echo $block;
}

$flush();
