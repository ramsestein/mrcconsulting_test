<?php
/**
 * Bloque «Equipo». Campos: site/blueprints/blocks/team.yml
 * Estilos: .b-team
 *
 * @var \Kirby\Cms\Block $block
 */
?>
<section class="block b-team"<?= $block->anchor()->isNotEmpty() ? ' id="' . esc($block->anchor(), 'attr') . '"' : '' ?>>
	<div class="container">
		<?php snippet('components/section-heading', [
			'eyebrow' => $block->eyebrow(),
			'title'   => $block->title(),
			'intro'   => $block->intro(),
		]) ?>

		<div class="team-grid">
			<?php foreach ($block->members()->toStructure() as $member): ?>
			<article class="person">
				<div class="person__avatar">
					<?php if ($photo = $member->photo()->toFile()): ?>
					<?= mrc_img($photo, '160px', 'avatar', ['alt' => '']) ?>
					<?php else: ?>
					<span aria-hidden="true"><?= mrc_initials($member->name()->value()) ?></span>
					<?php endif ?>
				</div>
				<h3 class="person__name"><?= esc($member->name()) ?></h3>
				<?php if ($member->role()->isNotEmpty()): ?>
				<p class="person__role"><?= esc($member->role()) ?></p>
				<?php endif ?>
				<?php if ($member->bio()->isNotEmpty()): ?>
				<div class="person__bio prose"><?= $member->bio() ?></div>
				<?php endif ?>
			</article>
			<?php endforeach ?>
		</div>
	</div>
</section>
