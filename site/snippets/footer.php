<?php
/**
 * Pie de página: presentación, contacto, enlaces legales y redes.
 * Se edita en el panel: Ajustes del sitio → «Pie de página».
 */
?>
<footer class="site-footer">
	<div class="container site-footer__grid">

		<div class="site-footer__about">
			<img class="site-footer__logo" src="<?= url('assets/img/logo-white.png') ?>" alt="<?= esc($site->title(), 'attr') ?>" width="103" height="56" loading="lazy">
			<?php if ($site->footerText()->isNotEmpty()): ?>
			<p><?= esc($site->footerText()) ?></p>
			<?php endif ?>
		</div>

		<div>
			<h2 class="site-footer__title"><?= t('footer.contact') ?></h2>
			<ul class="site-footer__list">
				<?php if ($site->email()->isNotEmpty()): ?>
				<li>
					<?php snippet('components/icon', ['name' => 'mail']) ?>
					<a href="mailto:<?= esc($site->email(), 'attr') ?>"><?= esc($site->email()) ?></a>
				</li>
				<?php endif ?>
				<?php if ($site->phone()->isNotEmpty()): ?>
				<li>
					<?php snippet('components/icon', ['name' => 'phone']) ?>
					<a href="tel:<?= esc(preg_replace('/[^0-9+]/', '', $site->phone()->value()), 'attr') ?>"><?= esc($site->phone()) ?></a>
				</li>
				<?php endif ?>
				<?php if ($site->address()->isNotEmpty()): ?>
				<li>
					<?php snippet('components/icon', ['name' => 'pin']) ?>
					<span><?= $site->address()->escape()->nl2br() ?></span>
				</li>
				<?php endif ?>
			</ul>
		</div>

		<div>
			<h2 class="site-footer__title"><?= t('footer.legal') ?></h2>
			<ul class="site-footer__list">
				<?php foreach ($site->legalPages()->toPages() as $legal): ?>
				<li><a href="<?= $legal->url() ?>"><?= esc($legal->title()) ?></a></li>
				<?php endforeach ?>
			</ul>
		</div>

		<?php if ($site->social()->isNotEmpty()): ?>
		<div>
			<h2 class="site-footer__title"><?= t('footer.follow') ?></h2>
			<ul class="social-links">
				<?php foreach ($site->social()->toStructure() as $network): ?>
				<li>
					<a href="<?= esc($network->url(), 'attr') ?>" rel="noopener" target="_blank" aria-label="<?= esc($network->network(), 'attr') ?>">
						<?php snippet('components/icon', ['name' => $network->network()->value()]) ?>
					</a>
				</li>
				<?php endforeach ?>
			</ul>
		</div>
		<?php endif ?>

	</div>

	<div class="site-footer__bottom">
		<div class="container">
			<p>© <?= date('Y') ?> <?= esc($site->title()) ?>. <?= t('footer.rights') ?></p>
		</div>
	</div>
</footer>
