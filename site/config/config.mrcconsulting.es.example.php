<?php

/**
 * PLANTILLA de ajustes para el servidor de IONOS.
 *
 * Cómo usarla:
 *   1. Copiar este archivo en el servidor como
 *      site/config/config.mrcconsulting.es.php
 *      (y otra copia como config.www.mrcconsulting.es.php si la web
 *      también responde con "www").
 *   2. Rellenar los datos reales. Ese archivo NO se sube a git.
 *
 * Si no se crea, la web funciona igual usando la función mail() de PHP,
 * que en IONOS suele bastar. SMTP es más fiable si los correos llegan
 * a la carpeta de spam.
 */

return [
	'email' => [
		'transport' => [
			'type'     => 'smtp',
			'host'     => 'smtp.ionos.es',
			'port'     => 587,
			'security' => 'tls',
			'auth'     => true,
			'username' => 'web@mrcconsulting.es',
			'password' => 'CONTRASEÑA-DEL-BUZÓN',
		],
	],
];
