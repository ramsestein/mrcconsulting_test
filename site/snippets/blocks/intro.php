<?php
/**
 * Bloque «Introducción». Campos: site/blueprints/blocks/intro.yml
 * Estilos: .b-intro
 *
 * @var \Kirby\Cms\Block $block
 */

$align      = $block->align()->or('center')->value();
$background = $block->background()->or('white')->value();
?>
<section class="block b-intro b-intro--<?= $align ?> bg-<?= $background ?>"<?= $block->anchor()->isNotEmpty() ? ' id="' . esc($block->anchor(), 'attr') . '"' : '' ?>>
	<div class="container container--narrow">
		<?php snippet('components/section-heading', [
			'eyebrow' => $block->eyebrow(),
			'title'   => $block->title(),
			'intro'   => $block->text(),
			'align'   => $align,
		]) ?>
	</div>
</section>
