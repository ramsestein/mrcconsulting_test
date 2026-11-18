<?php

/**
 * Idioma español.
 *
 * - Si a una página le falta un texto en español, se muestra el inglés
 *   (idioma principal).
 * - "translations" son los textos fijos de la interfaz (botones,
 *   etiquetas del formulario…). Se pueden editar desde el panel:
 *   Idiomas → Español → Variables.
 */

return [
	'code'      => 'es',
	'default'   => false,
	'direction' => 'ltr',
	'locale'    => [
		'LC_ALL' => 'es_ES.utf-8',
	],
	'name'      => 'Español',
	'url'       => '/es',
	'translations' => [
		// Navegación
		'nav.skip'         => 'Saltar al contenido',
		'nav.menu'         => 'Menú',
		'nav.close'        => 'Cerrar menú',
		'nav.main'         => 'Navegación principal',
		'nav.language'     => 'Idioma',

		// Blog
		'blog.readmore'    => 'Leer más',
		'blog.back'        => 'Volver al blog',
		'blog.empty'       => 'Todavía no hay entradas.',
		'blog.newer'       => 'Entradas más recientes',
		'blog.older'       => 'Entradas anteriores',

		// Pie de página
		'footer.contact'   => 'Contacto',
		'footer.legal'     => 'Legal',
		'footer.follow'    => 'Síguenos',
		'footer.rights'    => 'Todos los derechos reservados.',

		// Formulario de contacto
		'form.name'             => 'Nombre y apellidos',
		'form.email'            => 'Correo electrónico',
		'form.phone'            => 'Teléfono (opcional)',
		'form.orgType'          => 'Tipo de organización',
		'form.orgType.choose'   => 'Elige una opción',
		'form.orgName'          => 'Grupo académico / Hospital / Empresa',
		'form.studyType'        => 'Tipo de estudio',
		'form.sites'            => 'Número de centros',
		'form.stage'            => 'Fase del proyecto',
		'form.topic'            => '¿En qué necesitas ayuda?',
		'form.message'          => 'Cuéntanos tu proyecto',
		'form.consent'          => 'He leído y acepto la',
		'form.consent.link'     => 'política de privacidad',
		'form.required'         => 'Obligatorio',
		'form.submit'           => 'Enviar mensaje',
		'form.success'          => '¡Gracias! Hemos recibido tu mensaje y te responderemos en breve.',
		'form.error'            => 'Revisa los campos marcados.',
		'form.error.send'       => 'No se ha podido enviar el mensaje. Inténtalo más tarde o escríbenos por correo.',
		'form.error.spam'       => 'No se ha podido enviar el mensaje. Inténtalo de nuevo.',
		'form.error.limit'      => 'Demasiados mensajes en poco tiempo. Inténtalo más tarde.',
		'form.error.name'       => 'Escribe tu nombre.',
		'form.error.email'      => 'Escribe un correo electrónico válido.',
		'form.error.message'    => 'Cuéntanos brevemente tu proyecto.',
		'form.error.consent'    => 'Debes aceptar la política de privacidad.',
		'form.preview'          => 'Versión de vista previa: el formulario funcionará en la web definitiva.',

		// Formato de fecha (patrón ICU: https://unicode-org.github.io/icu/userguide/format_parse/datetime/)
		'date.format'      => "d 'de' MMMM 'de' y",

		// Varios
		'preview.banner'   => 'Versión de vista previa · no es la web definitiva',
		'error.back'       => 'Ir a la página de inicio',
	],
];
