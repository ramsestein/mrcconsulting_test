<?php
/**
 * Iconos SVG de línea (estilo «Lucide», licencia ISC).
 * Uso: snippet('components/icon', ['name' => 'check'])
 *
 * Para añadir un icono: copiar el contenido del <svg> desde
 * https://lucide.dev y añadirlo al listado con su nombre.
 *
 * @var string $name
 */

$icons = [
	'menu'       => '<path d="M4 6h16M4 12h16M4 18h16"/>',
	'close'      => '<path d="M18 6 6 18M6 6l12 12"/>',
	'check'      => '<path d="M20 6 9 17l-5-5"/>',
	'arrow'      => '<path d="M5 12h14M12 5l7 7-7 7"/>',
	'chevron'    => '<path d="m6 9 6 6 6-6"/>',
	'mail'       => '<rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 6L2 7"/>',
	'phone'      => '<path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"/>',
	'pin'        => '<path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/>',
	'calendar'   => '<rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/>',
	'linkedin'   => '<path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-4 0v7h-4v-7a6 6 0 0 1 6-6zM2 9h4v12H2z"/><circle cx="4" cy="4" r="2"/>',
	'x'          => '<path fill="currentColor" stroke="none" d="M17.75 3h3.07l-6.7 7.66L22 21h-6.17l-4.83-6.32L5.47 21H2.4l7.17-8.2L2 3h6.33l4.37 5.77L17.75 3Zm-1.08 16.17h1.7L7.4 4.73H5.58l11.09 14.44Z"/>',
	'instagram'  => '<rect x="2" y="2" width="20" height="20" rx="5"/><path d="M16 11.4A4 4 0 1 1 12.6 8 4 4 0 0 1 16 11.4zM17.5 6.5h.01"/>',
	'youtube'    => '<path d="M2.5 17a24.1 24.1 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.6 49.6 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.1 24.1 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.6 49.6 0 0 1-16.2 0A2 2 0 0 1 2.5 17"/><path d="m10 15 5-3-5-3z"/>',
];

$svg = $icons[$name] ?? $icons['arrow'];
?>
<svg class="icon icon--<?= esc($name, 'attr') ?>" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><?= $svg ?></svg>
