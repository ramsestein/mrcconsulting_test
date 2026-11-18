<?php
/**
 * Bloque «Llamada a la acción». Campos: site/blueprints/blocks/cta.yml
 * Estilos: .b-cta
 *
 * @var \Kirby\Cms\Block $block
 */

$color = $block->color()->or('gradient')->value();
?>
<section class="block b-cta b-cta--<?= $color ?>">
	<div class="container">
		<div class="b-cta__box">
			<h2 class="b-cta__title"><?= esc($block->title()) ?></h2>
			<?php if ($block->text()->isNotEmpty()): ?>
			<p class="b-cta__text"><?= $block->text()->escape()->nl2br() ?></p>
			<?php endif ?>
			<?php snippet('components/buttons', ['buttons' => $block->buttons(), 'inverse' => $color !== 'light']) ?>
		</div>
	</div>
</section>
