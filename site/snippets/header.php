<?php
/**
 * Cabecera: logo, menú principal, selector de idioma y botón destacado.
 *
 * El menú se edita en el panel: Ajustes del sitio → «Menú y cabecera».
 * En el móvil, el botón ☰ abre y cierra el menú (assets/js/site.js).
 */

$menu = $site->menu()->toStructure();
?>
<header class="site-header">
	<div class="container site-header__inner">

		<a class="site-logo" href="<?= $site->homePage()->url() ?>" aria-label="<?= esc($site->title(), 'attr') ?>">
			<img src="<?= url('assets/img/logo.png') ?>" alt="<?= esc($site->title(), 'attr') ?>" width="103" height="56">
		</a>

		<button class="nav-toggle" type="button" aria-expanded="false" aria-controls="site-nav"
			data-label-open="<?= esc(t('nav.menu'), 'attr') ?>" data-label-close="<?= esc(t('nav.close'), 'attr') ?>">
			<?php snippet('components/icon', ['name' => 'menu']) ?>
			<?php snippet('components/icon', ['name' => 'close']) ?>
			<span class="visually-hidden"><?= t('nav.menu') ?></span>
		</button>

		<nav id="site-nav" class="site-nav" aria-label="<?= esc(t('nav.main'), 'attr') ?>">
			<ul class="site-nav__list">
				<?php foreach ($menu as $item): ?>
				<?php $active = $item->anchor()->isEmpty() && mrc_is_active($item->link()) ?>
				<li>
					<a class="site-nav__link<?= $active ? ' is-active' : '' ?>"
						href="<?= mrc_link($item->link(), $item->anchor()->value()) ?>"
						<?= $active ? 'aria-current="page"' : '' ?>>
						<?= esc($item->label()) ?>
					</a>
				</li>
				<?php endforeach ?>
			</ul>

			<div class="site-nav__extra">
				<?php snippet('language-switch') ?>

				<?php if ($site->ctaLabel()->isNotEmpty() && $site->ctaLink()->isNotEmpty()): ?>
				<a class="btn btn--primary btn--small" href="<?= mrc_link($site->ctaLink()) ?>">
					<?= esc($site->ctaLabel()) ?>
				</a>
				<?php endif ?>
			</div>
		</nav>

	</div>
</header>
