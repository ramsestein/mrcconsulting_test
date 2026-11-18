<?php
/**
 * Bloque «Tarjetas». Campos: site/blueprints/blocks/cards.yml
 * Estilos: .b-cards
 *
 * Estilos disponibles (campo «style»):
 *   plain     → tarjeta blanca con borde
 *   numbered  → con número grande (01., 02.…)
 *   highlight → fondo con el degradado de la marca
 *   check     → lista compacta de títulos con marca ✓
 *
 * @var \Kirby\Cms\Block $block
 */

$style   = $block->style()->or('plain')->value();
$columns = $block->columns()->or('3')->value();
$items   = $block->items()->toStructure();
?>
<section class="block b-cards b-cards--<?= $style ?>"<?= $block->anchor()->isNotEmpty() ? ' id="' . esc($block->anchor(), 'attr') . '"' : '' ?>>
	<div class="container">
		<?php snippet('components/section-heading', [
			'eyebrow' => $block->eyebrow(),
			'title'   => $block->title(),
			'intro'   => $block->intro(),
		]) ?>

		<?php if ($style === 'check'): ?>
		<ul class="check-grid">
			<?php foreach ($items as $item): ?>
			<li><?php snippet('components/icon', ['name' => 'check']) ?><span><?= esc($item->title()) ?></span></li>
			<?php endforeach ?>
		</ul>

		<?php else: ?>
		<div class="card-grid card-grid--<?= esc($columns, 'attr') ?>">
			<?php foreach ($items as $item): ?>
			<article class="card">
				<?php if ($style === 'numbered'): ?>
				<p class="card__number" aria-hidden="true"><?= sprintf('%02d.', $items->indexOf($item) + 1) ?></p>
				<?php endif ?>

				<h3 class="card__title"><?= esc($item->title()) ?></h3>

				<?php if ($item->text()->isNotEmpty()): ?>
				<div class="card__text prose"><?= $item->text() ?></div>
				<?php endif ?>

				<?php if ($item->list()->isNotEmpty()): ?>
				<div class="card__list check-list"><?= $item->list() ?></div>
				<?php endif ?>

				<?php if ($item->link()->isNotEmpty()): ?>
				<a class="card__link" href="<?= mrc_link($item->link()) ?>">
					<?= esc($item->linkLabel()->or('→')) ?>
					<?php snippet('components/icon', ['name' => 'arrow']) ?>
				</a>
				<?php endif ?>
			</article>
			<?php endforeach ?>
		</div>
		<?php endif ?>
	</div>
</section>
