<?php
/**
 * Tarjeta de una entrada en la lista del blog.
 *
 * @var \Kirby\Cms\Page $post
 */

$cover = $post->cover()->toFile();
?>
<article class="post-card">
	<a class="post-card__link" href="<?= $post->url() ?>">
		<div class="post-card__media">
			<?php if ($cover): ?>
			<?= mrc_img($cover, '(min-width: 900px) 30vw, (min-width: 600px) 45vw, 100vw', 'card', ['alt' => '']) ?>
			<?php else: ?>
			<span class="post-card__placeholder" aria-hidden="true"></span>
			<?php endif ?>
		</div>
		<div class="post-card__body">
			<time class="post-card__date" datetime="<?= $post->date()->toDate('yyyy-MM-dd') ?>">
				<?= $post->date()->toDate(t('date.format')) ?>
			</time>
			<h2 class="post-card__title"><?= esc($post->title()) ?></h2>
			<?php if ($post->excerpt()->isNotEmpty()): ?>
			<p class="post-card__excerpt"><?= esc($post->excerpt()) ?></p>
			<?php endif ?>
			<span class="post-card__more"><?= t('blog.readmore') ?> <?php snippet('components/icon', ['name' => 'arrow']) ?></span>
		</div>
	</a>
</article>
