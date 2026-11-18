<?php
/**
 * =====================================================================
 *  Estructura común de TODAS las páginas: <head>, cabecera, contenido
 *  y pie. Las plantillas lo usan así:
 *
 *    <?php snippet('layout', slots: true) ?>
 *      … contenido de la página …
 *    <?php endsnippet() ?>
 *
 *  Piezas: head.php · header.php · footer.php (en esta misma carpeta)
 * =====================================================================
 */
?>
<!doctype html>
<html lang="<?= kirby()->language()?->code() ?? 'en' ?>" class="no-js">
<?php snippet('head') ?>
<body class="template-<?= $page->intendedTemplate()->name() ?>">
	<a class="skip-link" href="#main"><?= t('nav.skip') ?></a>

	<?php if (mrc_is_preview()): ?>
	<div class="preview-banner" role="note"><?= t('preview.banner') ?></div>
	<?php endif ?>

	<?php snippet('header') ?>

	<main id="main" tabindex="-1">
		<?= $slot ?>
	</main>

	<?php snippet('footer') ?>
</body>
</html>
