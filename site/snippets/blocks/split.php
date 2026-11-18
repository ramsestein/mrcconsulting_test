<?php
/**
 * Bloque «Texto + imagen». Campos: site/blueprints/blocks/split.yml
 * Estilos: .b-split
 *
 * @var \Kirby\Cms\Block $block
 */

$image    = $block->image()->toFile();
$position = $block->imagePosition()->or('right')->value();
$frame    = $block->frame()->isEmpty() || $block->frame()->toBool();
?>
<section class="block b-split b-split--image-<?= $position ?><?= $frame ? ' b-split--framed' : '' ?>"<?= $block->anchor()->isNotEmpty() ? ' id="' . esc($block->anchor(), 'attr') . '"' : '' ?>>
	<div class="container b-split__grid">
		<div class="b-split__text">
			<?php snippet('components/section-heading', [
				'eyebrow' => $block->eyebrow(),
				'title'   => $block->title(),
				'intro'   => $block->text(),
				'align'   => 'left',
			]) ?>
			<?php snippet('components/buttons', ['buttons' => $block->buttons()]) ?>
		</div>

		<?php if ($image): ?>
		<figure class="b-split__media">
			<?= mrc_img($image, '(min-width: 900px) 45vw, 100vw') ?>
		</figure>
		<?php endif ?>
	</div>
</section>
