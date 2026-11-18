<?php
/**
 * Bloque básico «Imagen» (sustituye al de Kirby para generar versiones
 * WebP adaptables). Campos: los del bloque estándar de Kirby.
 *
 * @var \Kirby\Cms\Block $block
 */

$image = $block->image()->toFile();

if ($image === null) {
	return;
}
?>
<figure class="prose-figure">
	<?= mrc_img($image, '(min-width: 800px) 760px, 100vw', 'default', [
		'alt' => $block->alt()->or($image->alt())->value() ?? '',
	]) ?>
	<?php if ($block->caption()->isNotEmpty()): ?>
	<figcaption><?= $block->caption() ?></figcaption>
	<?php endif ?>
</figure>
