<?php
/**
 * Plantilla «Entrada del blog». Campos: site/blueprints/pages/post.yml
 */

$cover = $page->cover()->toFile();
?>
<?php snippet('layout', slots: true) ?>

	<article class="post">
		<header class="page-header page-header--post">
			<div class="container container--narrow">
				<a class="post__back" href="<?= $page->parent()->url() ?>">← <?= t('blog.back') ?></a>
				<time class="post__date" datetime="<?= $page->date()->toDate('yyyy-MM-dd') ?>">
					<?= $page->date()->toDate(t('date.format')) ?>
				</time>
				<h1 class="page-header__title"><?= esc($page->title()) ?></h1>
				<?php if ($page->excerpt()->isNotEmpty()): ?>
				<p class="page-header__lead"><?= esc($page->excerpt()) ?></p>
				<?php endif ?>
			</div>
		</header>

		<?php if ($cover): ?>
		<div class="container container--narrow">
			<figure class="post__cover">
				<?= mrc_img($cover, '(min-width: 800px) 760px, 100vw', 'default', ['loading' => 'eager']) ?>
			</figure>
		</div>
		<?php endif ?>

		<?php snippet('blocks', ['blocks' => $page->text()->toBlocks()]) ?>
	</article>

<?php endsnippet() ?>
