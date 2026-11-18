# Web de MR&C Consulting

Web corporativa de **Medical Research and Clinical Consulting, S.L.** (mrcconsulting.es),
en inglés y español, hecha con [Kirby 5](https://getkirby.com): un gestor de contenidos
en PHP **sin base de datos**. El contenido son carpetas con archivos de texto.

> **¿Eres del equipo y quieres cambiar un texto?** Lee [docs/guia-editores.md](docs/guia-editores.md).
> No necesitas tocar nada de esta carpeta: todo se hace desde el panel (`https://mrcconsulting.es/panel`).

---

## Empieza aquí (para desarrolladores)

| Quiero…                                   | Mira                                                 |
|-------------------------------------------|------------------------------------------------------|
| Entender cómo está montada la web         | [docs/arquitectura.md](docs/arquitectura.md)         |
| Hacer un cambio concreto (receta)         | [docs/recetas.md](docs/recetas.md)                   |
| Subir la web al servidor / volver atrás   | [docs/despliegue-ionos.md](docs/despliegue-ionos.md) |
| Actualizar Kirby                          | [docs/actualizar-kirby.md](docs/actualizar-kirby.md) |
| Saber qué queda por revisar               | [docs/pendientes.md](docs/pendientes.md)             |

### Arrancar la web en tu ordenador

Necesitas **PHP 8.2 o superior** con las extensiones `gd`, `intl`, `mbstring` y `curl`.

```bash
php -S localhost:8000 kirby/router.php
```

Abre <http://localhost:8000> (web) y <http://localhost:8000/panel> (panel; la primera vez
te pedirá crear un usuario). En local el formulario no envía correos: los guarda en `site/logs/`.

No hay que instalar nada más: ni npm, ni Composer, ni compilar CSS. Se edita un archivo,
se guarda y se recarga el navegador.

---

## Mapa de carpetas

```
mrcconsulting/
├── README.md            ← este archivo
├── docs/                ← documentación (no es accesible desde la web)
├── .htaccess            ← reglas de Apache: HTTPS, redirecciones, seguridad, caché
├── index.php            ← entrada de Kirby (no se toca)
├── kirby/               ← núcleo del CMS (no se toca; se actualiza reemplazándolo)
├── site/                ← TODO EL CÓDIGO PROPIO
│   ├── blueprints/      ←   formularios del panel (qué campos ve el editor)
│   ├── templates/       ←   HTML de cada tipo de página
│   ├── snippets/        ←   piezas reutilizables (cabecera, pie, bloques…)
│   ├── controllers/     ←   lógica (formulario de contacto)
│   ├── plugins/mrc/     ←   código propio: seguridad, sitemap, utilidades
│   ├── languages/       ←   idiomas y textos fijos de la interfaz
│   └── config/          ←   configuración
├── content/             ← EL CONTENIDO (lo escribe el panel; se puede leer con cualquier editor)
├── assets/              ← CSS, JavaScript, fuentes e imágenes de la marca
├── media/               ← miniaturas generadas automáticamente (se puede borrar)
├── tools/               ← herramientas de desarrollo (no se usan en el servidor)
└── .github/             ← vista previa en GitHub Pages (solo durante el desarrollo)
```

La regla de oro: **el código está en `site/` y `assets/`; el contenido en `content/`**.

---

## Datos clave

- **Kirby** 5.6.3 · **PHP** 8.2+ (recomendado 8.4) · sin base de datos · sin dependencias de terceros.
- **Idiomas**: inglés (principal, `/en/…`) y español (`/es/…`). La raíz `/` redirige según el navegador.
- **Seguridad**: cabeceras HTTP estrictas, sin cookies de terceros, sin JavaScript externo,
  formulario con protección CSRF, campo trampa, límite de envíos y tiempo mínimo.
- **Licencia de Kirby**: se activa en el panel del servidor (no se guarda en git).
- **Vista previa**: mientras dura la aprobación, cada cambio en `main` se publica en
  GitHub Pages como copia estática (`tools/export-static.php`). Después, GitHub deja de usarse.
