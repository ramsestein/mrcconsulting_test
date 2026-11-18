# Recetas

Cambios habituales paso a paso. Antes de tocar el servidor, haz una copia de seguridad
(ver [despliegue-ionos.md](despliegue-ionos.md)).

---

## Cambiar un color o la tipografía de toda la web

Edita `assets/css/01-tokens.css`. Por ejemplo, para el azul de la marca:

```css
--c-blue: #106ab1;
```

Todos los botones, títulos y enlaces se actualizan solos.

---

## Añadir un tipo de bloque nuevo

Ejemplo: un bloque «Cifras» con números destacados.

1. **Formulario del panel** — crea `site/blueprints/blocks/stats.yml`:

   ```yaml
   # Bloque «Cifras». HTML: site/snippets/blocks/stats.php · Estilos: .b-stats
   name: Cifras
   icon: chart
   preview: fields
   wysiwyg: true
   fields:
     title:
       label: Título
       type: text
     items:
       label: Cifras
       type: structure
       fields:
         number: { label: Número, type: text }
         label:  { label: Texto, type: text }
   ```

2. **HTML** — crea `site/snippets/blocks/stats.php`:

   ```php
   <?php /** Bloque «Cifras». Campos: site/blueprints/blocks/stats.yml */ ?>
   <section class="block b-stats">
     <div class="container">
       <?php snippet('components/section-heading', ['eyebrow' => $block->eyebrow(), 'title' => $block->title()]) ?>
       <ul class="b-stats__list">
         <?php foreach ($block->items()->toStructure() as $item): ?>
         <li><strong><?= esc($item->number()) ?></strong> <?= esc($item->label()) ?></li>
         <?php endforeach ?>
       </ul>
     </div>
   </section>
   ```

3. **Estilos** — añade un apartado `.b-stats` en `assets/css/05-blocks.css`.

4. **Activarlo** — añade `- stats` a la lista de `site/blueprints/fields/blocks.yml`.

5. Explica el bloque en la tabla de `docs/guia-editores.md`.

---

## Añadir un campo a un bloque existente

1. Añade el campo en `site/blueprints/blocks/NOMBRE.yml`.
2. Úsalo en `site/snippets/blocks/NOMBRE.php` con `$block->nombreDelCampo()`.
   Comprueba si está vacío con `->isNotEmpty()` antes de pintarlo.

---

## Añadir un tipo de página nuevo

1. `site/blueprints/pages/NOMBRE.yml` (copia `default.yml` como base).
2. `site/templates/NOMBRE.php` (copia `default.php` como base).
3. Si necesita lógica, `site/controllers/NOMBRE.php`.
4. Para que el equipo pueda crearla desde el panel, añádela a `create:` en
   `site/blueprints/site.yml`.

---

## Añadir un texto fijo traducible (botones, etiquetas)

1. Añade la clave en `site/languages/en.php` y `es.php`, dentro de `translations`:
   `'blog.share' => 'Share'` / `'blog.share' => 'Compartir'`.
2. Úsala en la plantilla: `<?= t('blog.share') ?>`.

---

## Añadir un icono

`site/snippets/components/icon.php`: copia el contenido del `<svg>` de
<https://lucide.dev> y añádelo a la lista con un nombre. Úsalo con
`snippet('components/icon', ['name' => 'nombre'])`.

---

## Insertar un vídeo de YouTube, un mapa u otro contenido externo

La política de seguridad (CSP) solo permite contenido de la propia web. Para permitir
otro dominio, edita la cabecera en `site/plugins/mrc/index.php`. Por ejemplo, para
vídeos de YouTube sin cookies, añade:

```php
"frame-src https://www.youtube-nocookie.com",
```

y añade `video` a la lista de bloques en `site/blueprints/fields/blocks.yml`.
Si el contenido externo usa cookies, habrá que actualizar la política de cookies y,
probablemente, añadir un aviso de consentimiento.

---

## Añadir analítica respetuosa (sin cookies)

Si algún día se quiere medir visitas, usar una herramienta sin cookies (p. ej. Plausible
o Umami). Hay que añadir su script en `site/snippets/head.php`, su dominio a la CSP
(`script-src` y `connect-src`) y mencionarlo en la política de privacidad.

---

## Añadir una redirección

En `.htaccess`, apartado 2:

```apache
RewriteRule ^direccion-antigua$ /es/direccion-nueva [L,R=301]
```

---

## Cambiar el destinatario o el remitente del formulario

- Destinatario: panel → pantalla principal → pestaña **Formulario**.
- Remitente técnico: `site/config/config.php` → `mrc.form.from` (debe ser del dominio).
- Si los correos van a spam, configurar SMTP: ver `config.mrcconsulting.es.example.php`.
