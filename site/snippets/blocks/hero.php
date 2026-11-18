<?php
/**
 * Bloque «Portada (banner)». Campos: site/blueprints/blocks/hero.yml
 * Estilos: assets/css/05-blocks.css → .b-hero
 *
 * El título es el <h1> de la página cuando la portada es el primer bloque.
 *
 * @var \Kirby\Cms\Block $block
 */

$image = $block->image()->toFile();
?>
<section class="b-hero">
	<?php if ($image): ?>
	<div class="b-hero__media" aria-hidden="true">
		<?= mrc_img($image, '100vw', 'default', ['alt' => '', 'loading' => 'eager', 'fetchpriority' => 'high']) ?>
	</div>
	<?php endif ?>

	<div class="container b-hero__inner">
		<?php if ($block->eyebrow()->isNotEmpty()): ?>
		<p class="eyebrow eyebrow--light"><?= esc($block->eyebrow()) ?></p>
		<?php endif ?>

		<h1 class="b-hero__title"><?= $block->title()->escape()->nl2br() ?></h1>

		<?php if ($block->subtitle()->isNotEmpty()): ?>
		<p class="b-hero__subtitle"><?= $block->subtitle()->escape()->nl2br() ?></p>
		<?php endif ?>

		<?php snippet('components/buttons', ['buttons' => $block->buttons(), 'inverse' => true]) ?>
	</div>
</section>
