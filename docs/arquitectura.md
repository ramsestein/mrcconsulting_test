# Arquitectura

Cómo está montada la web, para quien tenga que mantenerla o ampliarla.

## Idea general

```
Visitante ──► Apache (.htaccess) ──► index.php ──► Kirby
                                                    │
                     content/ (textos e imágenes) ◄─┤  lee el contenido
                     site/templates + snippets    ◄─┤  pinta el HTML
                     site/plugins/mrc             ◄─┘  cabeceras, sitemap…
```

- **Sin base de datos.** Cada página es una carpeta en `content/` con un archivo de texto
  por idioma (`default.en.txt`, `default.es.txt`) y sus imágenes.
- **Sin compilación.** PHP, HTML, CSS y un JavaScript mínimo, tal cual.
- **Sin dependencias externas.** Ni Google Fonts, ni analítica, ni CDN. Todo se sirve
  desde el propio servidor.

## El contenido (`content/`)

```
content/
├── site.en.txt / site.es.txt     ← ajustes generales (menú, pie, formulario, SEO)
├── home/home.en.txt              ← página de inicio
├── 1_about-us/default.en.txt     ← el número es el orden; «default» es el tipo de página
├── 2_services/…
├── 6_blog/blog.en.txt
│   └── 20200113_sedar-agreement/post.en.txt   ← entradas: el número es la fecha
├── contact/contact.en.txt        ← sin número = página oculta (no listada)
└── error/error.en.txt            ← página 404
```

- El nombre de la carpeta es la dirección en inglés. La dirección en español va en el
  campo `Slug:` del archivo `.es.txt` (p. ej. `Slug: sobre-nosotros`).
- Los bloques se guardan como JSON en el campo `Blocks:`. Se pueden leer, pero es más
  cómodo editarlos desde el panel.
- Los enlaces entre páginas usan identificadores permanentes (`page://abc123…`), así que
  **cambiar la dirección de una página no rompe los enlaces ni el menú**.

## Tipos de página

| Tipo        | Formulario del panel              | Plantilla                    | Uso                                   |
|-------------|-----------------------------------|------------------------------|---------------------------------------|
| `home`      | `site/blueprints/pages/home.yml`  | `site/templates/home.php`    | Inicio                                |
| `default`   | `…/pages/default.yml`             | `…/templates/default.php`    | Casi todas: About, Services, legales… |
| `blog`      | `…/pages/blog.yml`                | `…/templates/blog.php`       | Lista de entradas                     |
| `post`      | `…/pages/post.yml`                | `…/templates/post.php`       | Entrada del blog                      |
| `contact`   | `…/pages/contact.yml`             | `…/templates/contact.php` + `site/controllers/contact.php` | Formulario |
| `error`     | `…/pages/error.yml`               | `…/templates/error.php`      | Página 404                            |

## Bloques

Cada tipo de bloque son **siempre dos archivos con el mismo nombre** + su sección de CSS:

| Archivo                               | Qué es                                  |
|---------------------------------------|-----------------------------------------|
| `site/blueprints/blocks/NOMBRE.yml`   | Campos que ve el editor en el panel     |
| `site/snippets/blocks/NOMBRE.php`     | HTML que se muestra en la web           |
| `assets/css/05-blocks.css` → `.b-NOMBRE` | Estilos                               |

Bloques propios: `hero`, `intro`, `split`, `cards`, `services`, `steps`, `team`, `pricing`,
`faq`, `cta`. Además se usan los bloques estándar de Kirby (`heading`, `text`, `list`,
`image`, `quote`); `image` está sobrescrito para generar imágenes adaptables.

La lista de bloques disponibles en las páginas está en `site/blueprints/fields/blocks.yml`.
`site/snippets/blocks.php` recorre los bloques y agrupa los de texto sencillo en una
columna de lectura.

### Campos reutilizables

En `site/blueprints/fields/` hay piezas que usan varios bloques: `anchor` (ancla para
enlazar a una sección), `eyebrow` (antetítulo), `writer` (texto con formato limitado),
`buttons` (botones), `topic` (tema del formulario). En `site/blueprints/tabs/seo.yml`
está la pestaña «Google y redes».

## Snippets (piezas de HTML)

| Snippet                            | Qué pinta                                           |
|------------------------------------|-----------------------------------------------------|
| `layout.php`                       | Estructura común: `<head>`, cabecera, `<main>`, pie |
| `head.php`                         | Meta etiquetas, SEO, hreflang, CSS y JS             |
| `header.php` / `language-switch.php` | Cabecera, menú y selector de idioma              |
| `footer.php`                       | Pie de página                                       |
| `page-header.php`                  | Cabecera de las páginas interiores                  |
| `post-card.php`                    | Tarjeta de entrada en el blog                       |
| `sitemap.php`                      | Contenido de `/sitemap.xml`                         |
| `components/section-heading.php`   | Antetítulo + título + línea de la marca + intro     |
| `components/buttons.php`           | Fila de botones                                     |
| `components/icon.php`              | Iconos SVG                                          |

Las plantillas usan los *slots* de Kirby:

```php
<?php snippet('layout', slots: true) ?>
  … contenido …
<?php endsnippet() ?>
```

## Código propio (`site/plugins/mrc/`)

- `index.php`: cabecera **Content-Security-Policy** en las páginas públicas (no en el
  panel), rutas `/sitemap.xml` y `/robots.txt`, métodos SEO (`seoTitle`, `seoDescription`,
  `seoImage`).
- `helpers.php`: funciones `mrc_*` para las plantillas (`mrc_link`, `mrc_img`, `mrc_asset`…).

## CSS (`assets/css/`)

Se cargan en este orden desde `head.php`. Cada archivo explica su contenido al principio.

| Archivo             | Contenido                                                          |
|---------------------|--------------------------------------------------------------------|
| `01-tokens.css`     | **Colores, fuentes, espacios de la marca** (variables CSS)         |
| `02-base.css`       | Reinicio, tipografía, utilidades, antetítulo, línea de la marca    |
| `03-layout.css`     | Cabecera, menú, pie, cabecera de página, espaciado de secciones    |
| `04-components.css` | Botones, tarjetas, listas ✓, avisos, formularios, tablas           |
| `05-blocks.css`     | Un apartado por bloque (`.b-hero`, `.b-cards`…)                    |
| `06-pages.css`      | Blog, entrada, contacto, error                                     |
| `panel.css`         | Retoque cosmético del panel                                        |

Los archivos llevan `?v=fecha` en la dirección para que el navegador descargue la versión
nueva en cuanto cambian.

## Idiomas

- Definidos en `site/languages/en.php` (principal) y `es.php`. Ahí están también los
  textos fijos de la interfaz (`translations`), que se usan en las plantillas con `t('clave')`.
- Inglés es el idioma principal: si falta un campo en español se muestra el inglés.

## Formulario de contacto

`site/controllers/contact.php`: valida, aplica las protecciones antispam (CSRF, campo
trampa, tiempo mínimo, límite por hora) y envía el correo con la plantilla
`site/templates/emails/contact.text.php`. No guarda nada en el servidor.
Ajustes en `config.php` → `mrc.form`. El destinatario se cambia en el panel.

## Seguridad

- `.htaccess`: HTTPS obligatorio, HSTS, `X-Frame-Options`, `nosniff`, `Referrer-Policy`,
  `Permissions-Policy`, bloqueo de `content/`, `site/`, `kirby/`, `docs/`, `tools/` y de
  archivos que empiezan por punto.
- CSP estricta desde PHP: solo recursos de la propia web, sin scripts ni estilos en línea.
  **No usar atributos `style="…"` ni `<script>` en línea en las plantillas.**
- Panel: máximo 5 intentos de acceso por hora; doble factor disponible (`config.php`).
- Sin plugins de terceros.

## Vista previa estática (solo desarrollo)

`tools/export-static.php` arranca Kirby en modo vista previa (`MRC_PREVIEW=1`: formulario
desactivado, `noindex`) y descarga todas las páginas del sitemap con sus archivos.
`.github/workflows/preview.yml` lo ejecuta y publica el resultado en GitHub Pages.
