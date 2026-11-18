<?php
/**
 * Encabezado estándar de sección: antetítulo, título, línea decorativa de
 * la marca y texto de introducción. Lo usan casi todos los bloques.
 *
 * Uso: snippet('components/section-heading', [
 *   'eyebrow' => $block->eyebrow(),
 *   'title'   => $block->title(),
 *   'intro'   => $block->intro(),   // opcional (campo writer)
 *   'align'   => 'center',          // 'center' | 'left'
 *   'level'   => 2,                 // nivel del título (h2, h3…)
 * ])
 */

$align ??= 'center';
$level ??= 2;
$intro ??= null;
$tag     = 'h' . (int) $level;

if ($eyebrow->isEmpty() && $title->isEmpty() && ($intro === null || $intro->isEmpty())) {
	return;
}
?>
<div class="section-heading section-heading--<?= $align ?>">
	<?php if ($eyebrow->isNotEmpty()): ?>
	<p class="eyebrow"><?= esc($eyebrow) ?></p>
	<?php endif ?>

	<?php if ($title->isNotEmpty()): ?>
	<<?= $tag ?> class="section-title"><?= esc($title) ?></<?= $tag ?>>
	<span class="brand-divider" aria-hidden="true"></span>
	<?php endif ?>

	<?php if ($intro !== null && $intro->isNotEmpty()): ?>
	<div class="section-intro prose"><?= $intro ?></div>
	<?php endif ?>
</div>
