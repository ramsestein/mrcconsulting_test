<?php

/**
 * =====================================================================
 *  Lógica del formulario de contacto (página «Contacto»).
 * ---------------------------------------------------------------------
 *  1. Muestra el formulario (y preselecciona el tema si llega ?topic=…).
 *  2. Al enviarlo, comprueba:
 *       - token CSRF (que el envío viene de esta web)
 *       - campo trampa «website» vacío (los robots lo rellenan)
 *       - tiempo mínimo desde que se abrió el formulario
 *       - límite de envíos por hora
 *       - campos obligatorios y formato del correo
 *  3. Envía un correo al destinatario de «Ajustes del sitio → Formulario»
 *     con «Responder a» la dirección del visitante.
 *
 *  No se guarda nada en el servidor (más sencillo para el RGPD).
 *  Plantilla del correo: site/templates/emails/contact.text.php
 *  Ajustes: config.php → 'mrc' → 'form'
 * =====================================================================
 */

use Kirby\Cms\App;
use Kirby\Cms\Page;
use Kirby\Cms\Site;
use Kirby\Toolkit\V;

return function (App $kirby, Site $site, Page $page) {

	$session  = $kirby->session();
	$options  = option('mrc.form', []);
	$preview  = mrc_is_preview();
	$errors   = [];
	$alert    = null;
	$sent     = get('sent') === '1';

	// Valores iniciales del formulario
	$data = [
		'name'      => '',
		'email'     => '',
		'phone'     => '',
		'orgType'   => '',
		'orgName'   => '',
		'studyType' => '',
		'sites'     => '',
		'stage'     => '',
		'topic'     => (string) get('topic', ''),
		'message'   => '',
		'consent'   => false,
	];

	// -----------------------------------------------------------------
	// Envío del formulario
	// -----------------------------------------------------------------
	if ($kirby->request()->is('POST') && $preview === false) {

		// Recoger y limpiar los datos enviados
		foreach (array_keys($data) as $key) {
			$data[$key] = $key === 'consent'
				? get('consent') === 'yes'
				: trim(strip_tags((string) get($key, '')));
		}

		$openedAt = (int) $session->get('mrc.form.openedAt', 0);
		$history  = array_filter(
			(array) $session->get('mrc.form.history', []),
			fn ($time) => $time > time() - 3600
		);

		// --- Comprobaciones antispam (sin mostrar detalles al robot) ---
		if (csrf(get('csrf')) !== true) {
			$alert = t('form.error.spam');
		} elseif (empty(get('website')) === false) {
			$alert = t('form.error.spam');
		} elseif ($openedAt === 0 || time() - $openedAt < ($options['minSeconds'] ?? 3)) {
			$alert = t('form.error.spam');
		} elseif (count($history) >= ($options['maxPerHour'] ?? 5)) {
			$alert = t('form.error.limit');
		}

		// --- Validación de campos ---
		if ($alert === null) {
			if (V::minLength($data['name'], 2) === false) {
				$errors['name'] = t('form.error.name');
			}
			if (V::email($data['email']) === false) {
				$errors['email'] = t('form.error.email');
			}
			if (V::minLength($data['message'], 10) === false) {
				$errors['message'] = t('form.error.message');
			}
			if ($data['consent'] !== true) {
				$errors['consent'] = t('form.error.consent');
			}
			// Limitar longitudes para evitar abusos
			foreach ($data as $key => $value) {
				if (is_string($value) && mb_strlen($value) > ($key === 'message' ? 5000 : 200)) {
					$errors[$key] = t('form.error');
				}
			}
			if (count($errors) > 0) {
				$alert = t('form.error');
			}
		}

		// --- Enviar ---
		if ($alert === null) {
			$topicLabel = $page->topics()->toStructure()->findBy('key', $data['topic'])?->label()->value() ?? $data['topic'];
			$emailData  = array_merge($data, [
				'topicLabel' => $topicLabel,
				'language'   => $kirby->language()?->name(),
				'pageUrl'    => $page->url(),
			]);

			try {
				if (($options['dryRun'] ?? false) === true) {
					// Modo prueba: guardar el mensaje en site/logs/ en lugar de enviarlo
					$log = $kirby->root('site') . '/logs/form-' . date('Ymd-His') . '.json';
					Kirby\Filesystem\F::write($log, json_encode($emailData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
				} else {
					$kirby->email([
						'template' => 'contact',
						'from'     => $options['from'] ?? 'web@mrcconsulting.es',
						'fromName' => $options['fromName'] ?? $site->title()->value(),
						'replyTo'  => $data['email'],
						'to'       => $site->formRecipient()->value(),
						'subject'  => $site->formSubject()->or('Nuevo mensaje desde la web')->value() . ' · ' . $data['name'],
						'data'     => $emailData,
					]);
				}

				$history[] = time();
				$session->set('mrc.form.history', $history);
			} catch (Throwable $error) {
				$alert = t('form.error.send');
			}

			// Redirigir para que recargar la página no reenvíe el formulario
			if ($alert === null) {
				go($page->url() . '?sent=1#form');
			}
		}
	}

	// Momento en que se abre el formulario (para la comprobación de tiempo)
	if ($kirby->request()->is('GET')) {
		$session->set('mrc.form.openedAt', time());
	}

	return [
		'data'    => $data,
		'errors'  => $errors,
		'alert'   => $alert,
		'sent'    => $sent,
		'preview' => $preview,
		'topics'  => $page->topics()->toStructure(),
	];
};
