<?php

/**
 * Ajustes SOLO para el ordenador de desarrollo (http://localhost:8000).
 *
 * Kirby combina este archivo con config.php: aquí solo se escribe lo
 * que cambia respecto a la configuración general.
 */

return [
	// Mostrar errores detallados mientras se desarrolla
	'debug' => true,

	'mrc' => [
		'form' => [
			// En local no se envían correos: se guardan en site/logs/
			'dryRun'     => true,
			'maxPerHour' => 50,
			'minSeconds' => 1,
		],
	],
];
