<?php

/**
 * Punto de entrada de la web.
 *
 * Todas las peticiones pasan por aquí (ver .htaccess) y Kirby decide
 * qué página mostrar. No hace falta tocar este archivo nunca.
 */

require __DIR__ . '/kirby/bootstrap.php';

echo (new Kirby())->render();
