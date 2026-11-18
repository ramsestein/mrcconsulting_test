<?php
/**
 * Plantilla «Contacto»: texto + formulario.
 * Campos: site/blueprints/pages/contact.yml
 * Lógica (validación y envío): site/controllers/contact.php
 *
 * Variables que llegan del controlador:
 * @var array  $data     Valores del formulario
 * @var array  $errors   Errores por campo
 * @var string $alert    Mensaje de error general
 * @var bool   $sent     true si se acaba de enviar correctamente
 * @var bool   $preview  true en la vista previa estática (no se puede enviar)
 * @var \Kirby\Cms\Structure $topics
 */

// Pinta un <select> con las opciones de un campo «tags» del panel
$select = function (string $name, string $label, array $options, string $current) {
	?>
	<div class="field">
		<label for="f-<?= $name ?>"><?= $label ?></label>
		<select id="f-<?= $name ?>" name="<?= $name ?>">
			<option value=""><?= t('form.orgType.choose') ?></option>
			<?php foreach ($options as $option): ?>
			<option value="<?= esc($option, 'attr') ?>"<?= $option === $current ? ' selected' : '' ?>><?= esc($option) ?></option>
			<?php endforeach ?>
		</select>
	</div>
	<?php
};

$privacy = $site->legalPages()->toPages()->filter(fn ($p) => str_contains($p->id(), 'privacy'))->first();
?>
<?php snippet('layout', slots: true) ?>

	<?php snippet('page-header') ?>

	<section class="block contact">
		<div class="container contact__grid">

			<div class="contact__info">
				<?php if ($page->intro()->isNotEmpty()): ?>
				<div class="prose"><?= $page->intro() ?></div>
				<?php endif ?>

				<ul class="contact__details">
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
				</ul>
			</div>

			<div class="contact__form card" id="form">
				<?php if ($sent): ?>
				<div class="alert alert--success" role="status">
					<?php snippet('components/icon', ['name' => 'check']) ?>
					<p><?= esc($page->success()->or(t('form.success'))) ?></p>
				</div>

				<?php else: ?>

				<?php if ($preview): ?>
				<div class="alert alert--info" role="note"><p><?= t('form.preview') ?></p></div>
				<?php endif ?>

				<?php if ($alert): ?>
				<div class="alert alert--error" role="alert"><p><?= esc($alert) ?></p></div>
				<?php endif ?>

				<form class="form" method="post" action="<?= $page->url() ?>#form" novalidate>
					<input type="hidden" name="csrf" value="<?= csrf() ?>">

					<!-- Campo trampa: invisible para las personas, los robots lo rellenan -->
					<div class="form__trap" aria-hidden="true">
						<label for="f-website">Website</label>
						<input type="text" id="f-website" name="website" tabindex="-1" autocomplete="off">
					</div>

					<div class="form__row">
						<div class="field<?= isset($errors['name']) ? ' has-error' : '' ?>">
							<label for="f-name"><?= t('form.name') ?> <span class="req" title="<?= t('form.required') ?>">*</span></label>
							<input type="text" id="f-name" name="name" value="<?= esc($data['name'], 'attr') ?>" required autocomplete="name"
								<?= isset($errors['name']) ? 'aria-invalid="true" aria-describedby="e-name"' : '' ?>>
							<?php if (isset($errors['name'])): ?><p class="field__error" id="e-name"><?= esc($errors['name']) ?></p><?php endif ?>
						</div>
						<div class="field<?= isset($errors['email']) ? ' has-error' : '' ?>">
							<label for="f-email"><?= t('form.email') ?> <span class="req" title="<?= t('form.required') ?>">*</span></label>
							<input type="email" id="f-email" name="email" value="<?= esc($data['email'], 'attr') ?>" required autocomplete="email"
								<?= isset($errors['email']) ? 'aria-invalid="true" aria-describedby="e-email"' : '' ?>>
							<?php if (isset($errors['email'])): ?><p class="field__error" id="e-email"><?= esc($errors['email']) ?></p><?php endif ?>
						</div>
					</div>

					<div class="form__row">
						<?php $select('orgType', t('form.orgType'), $page->orgTypes()->split(), $data['orgType']) ?>
						<div class="field">
							<label for="f-orgName"><?= t('form.orgName') ?></label>
							<input type="text" id="f-orgName" name="orgName" value="<?= esc($data['orgName'], 'attr') ?>" autocomplete="organization">
						</div>
					</div>

					<div class="form__row">
						<?php $select('studyType', t('form.studyType'), $page->studyTypes()->split(), $data['studyType']) ?>
						<?php $select('stage', t('form.stage'), $page->stages()->split(), $data['stage']) ?>
					</div>

					<div class="form__row">
						<div class="field">
							<label for="f-sites"><?= t('form.sites') ?></label>
							<input type="number" id="f-sites" name="sites" min="1" max="999" inputmode="numeric" value="<?= esc($data['sites'], 'attr') ?>">
						</div>
						<div class="field">
							<label for="f-topic"><?= t('form.topic') ?></label>
							<select id="f-topic" name="topic">
								<option value=""><?= t('form.orgType.choose') ?></option>
								<?php foreach ($topics as $topic): ?>
								<option value="<?= esc($topic->key(), 'attr') ?>"<?= $topic->key()->value() === $data['topic'] ? ' selected' : '' ?>><?= esc($topic->label()) ?></option>
								<?php endforeach ?>
							</select>
						</div>
					</div>

					<div class="field<?= isset($errors['phone']) ? ' has-error' : '' ?>">
						<label for="f-phone"><?= t('form.phone') ?></label>
						<input type="tel" id="f-phone" name="phone" value="<?= esc($data['phone'], 'attr') ?>" autocomplete="tel">
					</div>

					<div class="field<?= isset($errors['message']) ? ' has-error' : '' ?>">
						<label for="f-message"><?= t('form.message') ?> <span class="req" title="<?= t('form.required') ?>">*</span></label>
						<textarea id="f-message" name="message" rows="6" required
							<?= isset($errors['message']) ? 'aria-invalid="true" aria-describedby="e-message"' : '' ?>><?= esc($data['message']) ?></textarea>
						<?php if (isset($errors['message'])): ?><p class="field__error" id="e-message"><?= esc($errors['message']) ?></p><?php endif ?>
					</div>

					<div class="field field--check<?= isset($errors['consent']) ? ' has-error' : '' ?>">
						<input type="checkbox" id="f-consent" name="consent" value="yes"<?= $data['consent'] ? ' checked' : '' ?> required
							<?= isset($errors['consent']) ? 'aria-invalid="true" aria-describedby="e-consent"' : '' ?>>
						<label for="f-consent">
							<?= t('form.consent') ?>
							<?php if ($privacy): ?><a href="<?= $privacy->url() ?>" target="_blank"><?= t('form.consent.link') ?></a><?php else: ?><?= t('form.consent.link') ?><?php endif ?>
							<span class="req">*</span>
						</label>
						<?php if (isset($errors['consent'])): ?><p class="field__error" id="e-consent"><?= esc($errors['consent']) ?></p><?php endif ?>
					</div>

					<button class="btn btn--primary" type="submit"<?= $preview ? ' disabled' : '' ?>>
						<?= t('form.submit') ?>
						<?php snippet('components/icon', ['name' => 'arrow']) ?>
					</button>
				</form>
				<?php endif ?>
			</div>

		</div>
	</section>

<?php endsnippet() ?>
