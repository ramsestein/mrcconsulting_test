<?php
/**
 * Bloque «Tabla de precios». Campos: site/blueprints/blocks/pricing.yml
 * Estilos: .b-pricing
 *
 * Las columnas vacías (sin encabezado) no se muestran. En el móvil la tabla
 * se puede desplazar horizontalmente.
 *
 * @var \Kirby\Cms\Block $block
 */

$headers = array_filter([
	1 => $block->header1()->value(),
	2 => $block->header2()->value(),
	3 => $block->header3()->value(),
	4 => $block->header4()->value(),
], fn ($header) => $header !== null && trim($header) !== '');

$colspan = count($headers) + 1;
?>
<section class="block b-pricing"<?= $block->anchor()->isNotEmpty() ? ' id="' . esc($block->anchor(), 'attr') . '"' : '' ?>>
	<div class="container container--medium">
		<h2 class="b-pricing__title"><?= esc($block->title()) ?></h2>

		<?php if ($block->intro()->isNotEmpty()): ?>
		<div class="prose b-pricing__intro"><?= $block->intro() ?></div>
		<?php endif ?>

		<div class="table-scroll" tabindex="0" role="region" aria-label="<?= esc($block->title(), 'attr') ?>">
			<table class="price-table">
				<?php if (count($headers) > 0): ?>
				<thead>
					<tr>
						<th scope="col"><?= esc($block->conceptHeader()) ?></th>
						<?php foreach ($headers as $header): ?>
						<th scope="col"><?= esc($header) ?></th>
						<?php endforeach ?>
					</tr>
				</thead>
				<?php endif ?>
				<tbody>
					<?php foreach ($block->rows()->toStructure() as $row): ?>
					<?php if ($row->isGroup()->toBool()): ?>
					<tr class="price-table__group">
						<th scope="colgroup" colspan="<?= $colspan ?>"><?= esc($row->concept()) ?></th>
					</tr>
					<?php else: ?>
					<tr>
						<th scope="row"><?= esc($row->concept()) ?></th>
						<?php foreach (array_keys($headers) as $column): ?>
						<td><?= esc($row->{'price' . $column}()) ?></td>
						<?php endforeach ?>
					</tr>
					<?php endif ?>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>

		<?php if ($block->notes()->isNotEmpty()): ?>
		<div class="b-pricing__notes"><?= $block->notes() ?></div>
		<?php endif ?>
	</div>
</section>
