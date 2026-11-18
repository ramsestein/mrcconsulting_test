<?php
/**
 * Selector de idioma (EN | ES). Enlaza a la MISMA página en el otro idioma.
 */
?>
<ul class="lang-switch" aria-label="<?= esc(t('nav.language'), 'attr') ?>">
	<?php foreach (kirby()->languages() as $lang): ?>
	<?php $current = $lang->code() === kirby()->language()?->code() ?>
	<li>
		<a href="<?= $page->url($lang->code()) ?>"
			hreflang="<?= $lang->code() ?>"
			lang="<?= $lang->code() ?>"
			title="<?= esc($lang->name(), 'attr') ?>"
			<?= $current ? 'aria-current="true" class="is-active"' : '' ?>>
			<?= strtoupper($lang->code()) ?>
		</a>
	</li>
	<?php endforeach ?>
</ul>
