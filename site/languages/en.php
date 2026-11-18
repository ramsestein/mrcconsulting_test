<?php

/**
 * Idioma inglés (idioma PRINCIPAL de la web).
 *
 * - Si a una página le falta un texto en español, se muestra el inglés.
 * - "translations" son los textos fijos de la interfaz (botones,
 *   etiquetas del formulario…). Se pueden editar desde el panel:
 *   Idiomas → English → Variables.
 */

return [
	'code'      => 'en',
	'default'   => true,
	'direction' => 'ltr',
	'locale'    => [
		'LC_ALL' => 'en_GB.utf-8',
	],
	'name'      => 'English',
	'url'       => '/en',
	'translations' => [
		// Navegación
		'nav.skip'         => 'Skip to content',
		'nav.menu'         => 'Menu',
		'nav.close'        => 'Close menu',
		'nav.main'         => 'Main navigation',
		'nav.language'     => 'Language',

		// Blog
		'blog.readmore'    => 'Read more',
		'blog.back'        => 'Back to the blog',
		'blog.empty'       => 'There are no posts yet.',
		'blog.newer'       => 'Newer posts',
		'blog.older'       => 'Older posts',

		// Pie de página
		'footer.contact'   => 'Contact',
		'footer.legal'     => 'Legal',
		'footer.follow'    => 'Follow us',
		'footer.rights'    => 'All rights reserved.',

		// Formulario de contacto
		'form.name'             => 'Full name',
		'form.email'            => 'Email',
		'form.phone'            => 'Phone (optional)',
		'form.orgType'          => 'Organisation type',
		'form.orgType.choose'   => 'Choose an option',
		'form.orgName'          => 'Academic group / Hospital / Company',
		'form.studyType'        => 'Type of study',
		'form.sites'            => 'Number of sites',
		'form.stage'            => 'Stage of the project',
		'form.topic'            => 'What do you need help with?',
		'form.message'          => 'Tell us about your project',
		'form.consent'          => 'I have read and accept the',
		'form.consent.link'     => 'privacy policy',
		'form.required'         => 'Required',
		'form.submit'           => 'Send message',
		'form.success'          => 'Thank you! We have received your message and will get back to you shortly.',
		'form.error'            => 'Please review the highlighted fields.',
		'form.error.send'       => 'The message could not be sent. Please try again later or write to us by email.',
		'form.error.spam'       => 'The message could not be sent. Please try again.',
		'form.error.limit'      => 'Too many messages in a short time. Please try again later.',
		'form.error.name'       => 'Please enter your name.',
		'form.error.email'      => 'Please enter a valid email address.',
		'form.error.message'    => 'Please tell us briefly about your project.',
		'form.error.consent'    => 'You must accept the privacy policy.',
		'form.preview'          => 'Preview version: the form will be active on the final website.',

		// Formato de fecha (patrón ICU: https://unicode-org.github.io/icu/userguide/format_parse/datetime/)
		'date.format'      => 'd MMMM y',

		// Varios
		'preview.banner'   => 'Preview version · not the final website',
		'error.back'       => 'Go to the home page',
	],
];
