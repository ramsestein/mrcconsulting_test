<?php

/**
 * =====================================================================
 *  Plugin «mrc»: el código propio de la web que no es plantilla.
 * ---------------------------------------------------------------------
 *  - Cabeceras de seguridad de las páginas públicas (CSP)
 *  - Rutas especiales: /sitemap.xml y /robots.txt
 *  - Métodos de ayuda para SEO (título, descripción, imagen al compartir)
 *  - Funciones de ayuda para plantillas (helpers.php)
 *
 *  Documentación de plugins de Kirby: https://getkirby.com/docs/guide/plugins
 * =====================================================================
 */

use Kirby\Cms\App as Kirby;
use Kirby\Cms\Page;
use Kirby\Cms\Response;

require_once __DIR__ . '/helpers.php';

Kirby::plugin('mrc/core', [

	// -----------------------------------------------------------------
	// Hooks: código que se ejecuta automáticamente en ciertos momentos
	// -----------------------------------------------------------------
	'hooks' => [

		/**
		 * Antes de mostrar cualquier página pública, añade las cabeceras de
		 * seguridad. El panel de edición no pasa por aquí, así que no le afecta.
		 */
		'page.render:before' => function (string $contentType, array $data, Page $page) {
			$response = kirby()->response();

			// Política de contenidos: solo se cargan archivos de esta misma web.
			// Si algún día se inserta un vídeo de YouTube o un mapa, habrá que
			// añadir su dominio aquí (ver docs/recetas.md).
			$response->header('Content-Security-Policy', implode('; ', [
				"default-src 'self'",
				"img-src 'self' data:",
				"style-src 'self'",
				"script-src 'self'",
				"font-src 'self'",
				"form-action 'self'",
				"frame-ancestors 'self'",
				"base-uri 'self'",
				"object-src 'none'",
			]));

			// En la vista previa, pedir a los buscadores que no indexen
			if (mrc_is_preview()) {
				$response->header('X-Robots-Tag', 'noindex, nofollow');
			}

			return $data;
		},
	],

	// -----------------------------------------------------------------
	// Rutas especiales
	// -----------------------------------------------------------------
	'routes' => [

		/**
		 * /sitemap.xml: lista de todas las páginas públicas en ambos idiomas
		 * para que Google las encuentre. Se genera sola.
		 */
		[
			'pattern' => 'sitemap.xml',
			'method'  => 'GET',
			'action'  => function () {
				$kirby = kirby();
				$pages = site()->index()
					->filter(fn (Page $p) => $p->isPublished() && $p->intendedTemplate()->name() !== 'error');

				$xml = snippet('sitemap', ['pages' => $pages, 'languages' => $kirby->languages()], true);

				return new Response($xml, 'application/xml');
			},
		],

		/**
		 * /robots.txt: instrucciones para buscadores. En la vista previa
		 * prohíbe indexar; en la web real apunta al sitemap.
		 */
		[
			'pattern' => 'robots.txt',
			'method'  => 'GET',
			'action'  => function () {
				$lines = mrc_is_preview()
					? ['User-agent: *', 'Disallow: /']
					: ['User-agent: *', 'Disallow: /panel', 'Allow: /', '', 'Sitemap: ' . url('sitemap.xml')];

				return new Response(implode("\n", $lines) . "\n", 'text/plain');
			},
		],
	],

	// -----------------------------------------------------------------
	// Métodos de página para SEO (se usan en site/snippets/head.php)
	// -----------------------------------------------------------------
	'pageMethods' => [

		/** Título para la pestaña del navegador y Google */
		'seoTitle' => function (): string {
			/** @var Page $this */
			$title = $this->metaTitle()->or($this->title())->value();

			return $this->isHomePage()
				? site()->title()->value()
				: $title . ' · ' . site()->title()->value();
		},

		/** Descripción para Google: la de la página o la general */
		'seoDescription' => function (): string {
			/** @var Page $this */
			return $this->metaDescription()
				->or($this->lead())
				->or($this->excerpt())
				->or(site()->metaDescription())
				->excerpt(170)
				->value();
		},

		/** Imagen al compartir en redes: la de la página o la general */
		'seoImage' => function () {
			/** @var Page $this */
			return $this->ogImage()->toFile()
				?? $this->cover()->toFile()
				?? site()->ogImage()->toFile();
		},
	],
]);
