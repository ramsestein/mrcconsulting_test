# Actualizar Kirby

Kirby es el núcleo del gestor de contenidos (carpeta `kirby/`). El código propio
(`site/`, `assets/`) y el contenido (`content/`) no se tocan al actualizar.

Versión instalada: **5.6.3** (noviembre de 2026).

## Actualizaciones menores (5.x → 5.y)

Corrigen errores y fallos de seguridad. Conviene aplicarlas cada pocos meses.

1. **Copia de seguridad** de la carpeta de la web (ver `despliegue-ionos.md`).
2. Descarga la última versión 5.x de <https://github.com/getkirby/kirby/releases>
   (archivo `Source code (zip)`).
3. Descomprímela y renombra la carpeta a `kirby`.
4. Por SFTP, renombra en el servidor `kirby` → `kirby-old` y sube la nueva `kirby`.
5. Comprueba la web y el panel. Si algo falla, borra la nueva y renombra `kirby-old` → `kirby`.
6. Borra `kirby-old` y, si quieres, el contenido de `media/` (se regenera solo).
7. Actualiza la versión en este archivo y en el `README.md`.

## Actualizaciones mayores (5 → 6)

Pueden requerir cambios en `site/`. Lee antes la guía de actualización oficial
(<https://getkirby.com/releases>) y pruébala en local (`php -S localhost:8000 kirby/router.php`).
La licencia incluye 3 años de actualizaciones desde la activación.

## Avisos de seguridad

Kirby publica los avisos en <https://getkirby.com/security>. Merece la pena suscribirse
a su boletín o revisar esa página de vez en cuando.

## PHP

Kirby 5 funciona con PHP 8.2–8.5. Cuando IONOS avise del fin de soporte de una versión de
PHP, sube a la siguiente en el panel de IONOS (*Hosting* → *PHP*) y comprueba la web.
