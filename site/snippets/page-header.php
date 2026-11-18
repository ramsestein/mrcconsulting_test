<?php
/**
 * Cabecera de las páginas interiores: título + subtítulo sobre un fondo
 * suave con el motivo de la marca.
 * No se muestra si el primer bloque de la página es una «Portada».
 *
 * @var \Kirby\Cms\Page $page
 */
?>
<header class="page-header">
	<div class="container page-header__inner">
		<h1 class="page-header__title"><?= esc($page->title()) ?></h1>
		<?php if ($page->lead()->isNotEmpty()): ?>
		<p class="page-header__lead"><?= esc($page->lead()) ?></p>
		<?php endif ?>
	</div>
</header>
