<?php
/**
 * Plantilla de la página de error 404. Campos: site/blueprints/pages/error.yml
 */
?>
<?php snippet('layout', slots: true) ?>

	<section class="page-header page-header--error">
		<div class="container page-header__inner">
			<p class="error-code" aria-hidden="true">404</p>
			<h1 class="page-header__title"><?= esc($page->title()) ?></h1>
			<?php if ($page->lead()->isNotEmpty()): ?>
			<p class="page-header__lead"><?= esc($page->lead()) ?></p>
			<?php endif ?>
			<div class="btn-row">
				<a class="btn btn--primary" href="<?= $site->homePage()->url() ?>"><?= t('error.back') ?></a>
			</div>
		</div>
	</section>

<?php endsnippet() ?>
