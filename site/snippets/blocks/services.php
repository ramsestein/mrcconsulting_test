<?php
/**
 * Bloque «Grupo de servicios». Campos: site/blueprints/blocks/services.yml
 * Estilos: .b-services
 *
 * Cada servicio es un desplegable nativo de HTML (<details>), así que
 * funciona sin JavaScript y es accesible con teclado.
 *
 * @var \Kirby\Cms\Block $block
 */

$layout = $block->layout()->or('accordion')->value();
$items  = $block->items()->toStructure();
?>
<section class="block b-services b-services--<?= $layout ?>"<?= $block->anchor()->isNotEmpty() ? ' id="' . esc($block->anchor(), 'attr') . '"' : '' ?>>
	<div class="container">
		<div class="b-services__head">
			<?php snippet('components/section-heading', [
				'eyebrow' => $block->eyebrow(),
				'title'   => $block->title(),
				'align'   => 'left',
			]) ?>
			<?php if ($block->subtitle()->isNotEmpty()): ?>
			<p class="b-services__subtitle"><?= esc($block->subtitle()) ?></p>
			<?php endif ?>
			<?php if ($block->intro()->isNotEmpty()): ?>
			<div class="prose b-services__intro"><?= $block->intro() ?></div>
			<?php endif ?>
		</div>

		<div class="b-services__list">
			<?php foreach ($items as $item): ?>
			<?php $tag = $layout === 'accordion' ? 'details' : 'article' ?>
			<<?= $tag ?> class="service">
				<?php if ($layout === 'accordion'): ?>
				<summary class="service__summary">
					<span class="service__title"><?= esc($item->title()) ?></span>
					<?php if ($item->lead()->isNotEmpty()): ?>
					<span class="service__lead"><?= esc($item->lead()) ?></span>
					<?php endif ?>
					<?php snippet('components/icon', ['name' => 'chevron']) ?>
				</summary>
				<?php else: ?>
				<h3 class="service__title"><?= esc($item->title()) ?></h3>
				<?php if ($item->lead()->isNotEmpty()): ?>
				<p class="service__lead"><?= esc($item->lead()) ?></p>
				<?php endif ?>
				<?php endif ?>

				<div class="service__body">
					<?php if ($item->listTitle()->isNotEmpty()): ?>
					<p class="service__list-title"><?= esc($item->listTitle()) ?></p>
					<?php endif ?>

					<?php if ($item->list()->isNotEmpty()): ?>
					<div class="check-list check-list--columns"><?= $item->list() ?></div>
					<?php endif ?>

					<?php if ($item->closing()->isNotEmpty()): ?>
					<p class="service__closing"><?= esc($item->closing()) ?></p>
					<?php endif ?>

					<?php if ($item->button()->isNotEmpty() && $item->link()->isNotEmpty()): ?>
					<a class="btn btn--secondary btn--small" href="<?= mrc_link($item->link(), null, $item->topic()->value()) ?>">
						<?= esc($item->button()) ?>
						<?php snippet('components/icon', ['name' => 'arrow']) ?>
					</a>
					<?php endif ?>
				</div>
			</<?= $tag ?>>
			<?php endforeach ?>
		</div>
	</div>
</section>
