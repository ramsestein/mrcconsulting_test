<?php
/**
 * Fila de botones a partir del campo reutilizable «Botones»
 * (site/blueprints/fields/buttons.yml).
 *
 * Uso: snippet('components/buttons', ['buttons' => $block->buttons(), 'inverse' => false])
 *
 * @var \Kirby\Content\Field $buttons
 * @var bool $inverse  true = botones claros para fondos oscuros
 */

$inverse ??= false;
$items     = $buttons->toStructure();

if ($items->isEmpty()) {
	return;
}
?>
<div class="btn-row">
	<?php foreach ($items as $button): ?>
	<?php
		$style = $button->style()->or('primary')->value();
		$class = 'btn btn--' . $style . ($inverse ? ' btn--inverse' : '');
	?>
	<a class="<?= $class ?>" href="<?= mrc_link($button->link(), null, $button->topic()->value()) ?>">
		<?= esc($button->label()) ?>
		<?php snippet('components/icon', ['name' => 'arrow']) ?>
	</a>
	<?php endforeach ?>
</div>
