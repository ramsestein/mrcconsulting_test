<?php
/**
 * Bloque «Proceso (pasos)». Campos: site/blueprints/blocks/steps.yml
 * Estilos: .b-steps
 *
 * Se muestra como una línea de tiempo horizontal en pantallas grandes y
 * vertical en el móvil. Es una lista ordenada (<ol>): accesible y semántica.
 *
 * @var \Kirby\Cms\Block $block
 */

$steps = $block->steps()->toStructure();
?>
<section class="block b-steps bg-tint"<?=$block->anchor()->isNotEmpty() ? ' id="' . esc($block->anchor(), 'attr') . '"' : '' ?>>
	<div class="container">
		<?php snippet('components/section-heading', [
			'eyebrow' => $block->eyebrow(),
			'title'   => $block->title(),
			'intro'   => $block->intro(),
		]) ?>

		<ol class="steps steps--<?= min($steps->count(), 10) ?>">
			<?php foreach ($steps as $step): ?>
			<li class="step">
				<span class="step__dot" aria-hidden="true"></span>
				<span class="step__title"><?= esc($step->title()) ?></span>
				<?php if ($step->text()->isNotEmpty()): ?>
				<span class="step__text"><?= esc($step->text()) ?></span>
				<?php endif ?>
			</li>
			<?php endforeach ?>
		</ol>

		<?php if ($block->closing()->isNotEmpty()): ?>
		<p class="b-steps__closing"><?= esc($block->closing()) ?></p>
		<?php endif ?>
	</div>
</section>
