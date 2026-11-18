<?php
/**
 * Bloque «Preguntas frecuentes». Campos: site/blueprints/blocks/faq.yml
 * Estilos: .b-faq
 *
 * @var \Kirby\Cms\Block $block
 */
?>
<section class="block b-faq"<?= $block->anchor()->isNotEmpty() ? ' id="' . esc($block->anchor(), 'attr') . '"' : '' ?>>
	<div class="container container--narrow">
		<?php snippet('components/section-heading', [
			'eyebrow' => $block->eyebrow(),
			'title'   => $block->title(),
		]) ?>

		<div class="faq-list">
			<?php foreach ($block->items()->toStructure() as $item): ?>
			<details class="faq">
				<summary class="faq__question">
					<span><?= esc($item->question()) ?></span>
					<?php snippet('components/icon', ['name' => 'chevron']) ?>
				</summary>
				<div class="faq__answer prose"><?= $item->answer() ?></div>
			</details>
			<?php endforeach ?>
		</div>
	</div>
</section>
