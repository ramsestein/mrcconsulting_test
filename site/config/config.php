<?php

/**
 * =====================================================================
 *  Configuración general de la web
 * ---------------------------------------------------------------------
 *  Kirby lee este archivo en cada petición. Aquí solo hay ajustes:
 *  el código propio (rutas, cabeceras, utilidades) está en
 *  site/plugins/mrc/index.php.
 *
 *  Ajustes específicos de cada servidor (contraseñas SMTP, modo debug…)
 *  van en archivos con el nombre del dominio, que Kirby carga además
 *  de este:
 *    - config.localhost.php        → ordenador de desarrollo
 *    - config.mrcconsulting.es.php → servidor de IONOS (NO va en git;
 *                                    ver config.mrcconsulting.es.example.php)
 *
 *  Referencia completa de opciones: https://getkirby.com/docs/reference/system/options
 * =====================================================================
 */

return [

	// Nunca mostrar errores técnicos a los visitantes
	'debug' => false,

	// -----------------------------------------------------------------
	// Idiomas: inglés (principal) y español.
	// Cada idioma se define en site/languages/en.php y es.php.
	// La raíz "/" redirige al idioma del navegador del visitante.
	// -----------------------------------------------------------------
	'languages'        => true,
	'languages.detect' => true,

	// -----------------------------------------------------------------
	// Panel de edición (https://dominio/panel)
	// -----------------------------------------------------------------
	'panel' => [
		'language' => 'es_ES',
		// Estilos propios del panel (solo cosmética, opcional)
		'css'      => 'assets/css/panel.css',
	],

	// Intentos de acceso fallidos permitidos por hora antes de bloquear
	'auth' => [
		'trials'  => 5,
		'methods' => [
			// Para exigir un segundo factor (código por email o app de
			// autenticación) cambiar a ['2fa' => true].
			// ¡Activarlo SOLO después de comprobar que el servidor envía
			// correos! Ver docs/despliegue-ionos.md
			'password' => ['2fa' => false],
		],
	],

	// -----------------------------------------------------------------
	// Imágenes: Kirby genera versiones reducidas en formato WebP
	// automáticamente (carpeta media/).
	// -----------------------------------------------------------------
	'thumbs' => [
		'driver'  => 'gd',
		'quality' => 80,
		'format'  => 'webp',
		'srcsets' => [
			'default' => [480, 800, 1200, 1600, 2000],
			'card'    => [400, 640, 960],
			'avatar'  => [160, 320],
		],
	],

	// Fechas con el formato de cada idioma (p. ej. «18 de noviembre de 2026»)
	'date.handler' => 'intl',

	// Comillas y guiones tipográficos en los textos
	'smartypants' => true,

	// -----------------------------------------------------------------
	// Opciones propias de esta web (las lee site/plugins/mrc/index.php)
	// -----------------------------------------------------------------
	'mrc' => [
		// Vista previa estática para GitHub Pages: desactiva el envío del
		// formulario y pide a Google que no indexe. Lo activa la variable
		// de entorno MRC_PREVIEW=1 (solo en tools/export-static.php).
		'preview' => getenv('MRC_PREVIEW') === '1',

		'form' => [
			// Remitente técnico de los correos del formulario. Debe ser
			// una dirección del propio dominio para que IONOS lo acepte.
			// El destinatario se cambia desde el panel (Ajustes del sitio).
			'from'     => 'web@mrcconsulting.es',
			'fromName' => 'Web MR&C Consulting',

			// Máximo de envíos por visitante y hora (antispam)
			'maxPerHour' => 5,

			// Segundos mínimos entre abrir el formulario y enviarlo
			// (los robots lo rellenan al instante)
			'minSeconds' => 3,

			// true = no envía el correo, lo guarda en site/logs/ (pruebas)
			'dryRun' => false,
		],
	],

];
