<?php
/**
 * Plantilla «Blog»: lista de entradas, de la más nueva a la más antigua,
 * con paginación. Campos: site/blueprints/pages/blog.yml
 */

$perPage = $page->perPage()->or(9)->toInt();
$posts   = $page->children()->listed()->sortBy('date', 'desc')->paginate($perPage);
?>
<?php snippet('layout', slots: true) ?>

	<?php snippet('page-header') ?>

	<section class="block">
		<div class="container">
			<?php if ($posts->isEmpty()): ?>
			<p class="empty-state"><?= t('blog.empty') ?></p>
			<?php else: ?>
			<div class="post-grid">
				<?php foreach ($posts as $post): ?>
				<?php snippet('post-card', ['post' => $post]) ?>
				<?php endforeach ?>
			</div>
			<?php endif ?>

			<?php $pagination = $posts->pagination() ?>
			<?php if ($pagination->hasPages()): ?>
			<nav class="pagination">
				<?php if ($pagination->hasNextPage()): ?>
				<a class="btn btn--secondary btn--small" href="<?= $pagination->nextPageUrl() ?>"><?= t('blog.older') ?></a>
				<?php endif ?>
				<?php if ($pagination->hasPrevPage()): ?>
				<a class="btn btn--secondary btn--small" href="<?= $pagination->prevPageUrl() ?>"><?= t('blog.newer') ?></a>
				<?php endif ?>
			</nav>
			<?php endif ?>
		</div>
	</section>

<?php endsnippet() ?>
