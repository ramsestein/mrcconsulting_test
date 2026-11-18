# Despliegue en IONOS

Cómo poner la web en marcha la primera vez, cómo hacer copias de seguridad y cómo
volver atrás.

> ⚠️ **Después de la puesta en marcha, el contenido «bueno» está en el servidor.**
> El equipo edita desde el panel y eso se guarda en `content/` del servidor. Nunca
> subas una carpeta `content/` antigua encima: borrarías sus cambios.

---

## Requisitos

- Hosting de IONOS con **PHP 8.2 o superior** (recomendado 8.4).
- Acceso **SFTP/SSH** (panel de IONOS → *Hosting* → *SFTP & SSH* → crear usuario).
  Servidor del tipo `accessXXXXXXXX.webspace-data.io`, puerto 22.
- La licencia de Kirby (correo + clave de licencia).

---

## 1. Preparar el paquete

Desde la carpeta del proyecto, genera una copia limpia (sin usuarios de prueba, sesiones,
caché ni archivos de desarrollo):

```bash
git archive --format=zip -o ../mrcconsulting-web.zip HEAD
```

`git archive` deja fuera lo que no está en git (`site/accounts`, `site/sessions`,
`site/cache`, `media`, licencia…) y lo marcado en `.gitattributes` (`.github/`, `tools/`).

Descomprime el zip en una carpeta, p. ej. `mrcconsulting-web/`.

## 2. Subir por SFTP / scp

Sube la carpeta **al lado** de la del WordPress (no dentro):

```bash
scp -r mrcconsulting-web USUARIO@accessXXXXXXXX.webspace-data.io:~/
```

(También vale FileZilla o WinSCP.) Comprueba que se ha subido el archivo oculto `.htaccess`.

## 3. PHP

Panel de IONOS → *Hosting* → **PHP** → selecciona el dominio → **PHP 8.4** → guardar.
En IONOS la versión se asigna por dominio.

## 4. Apuntar el dominio a la carpeta

Panel de IONOS → *Dominios y SSL* → `mrcconsulting.es` → **cambiar destino / uso del
dominio** → *Webspace* → elige la carpeta `mrcconsulting-web`. Repite con `www.mrcconsulting.es`.

- No hay que tocar los registros DNS (y **no tocar los MX**, que son los del correo).
- El certificado SSL sigue funcionando: comprueba que `https://` carga sin avisos.

## 5. Crear el primer usuario del panel

Por seguridad, Kirby no deja crear usuarios desde internet salvo que se permita
expresamente. Para el primer usuario:

1. En el servidor, crea `site/config/config.mrcconsulting.es.php` con:

   ```php
   <?php
   return ['panel' => ['install' => true]];
   ```

2. Abre `https://mrcconsulting.es/panel` y crea la cuenta de **Administrador**.
3. **Borra** `'install' => true` (o el archivo entero) en cuanto esté creada.
4. Crea los usuarios del equipo con el rol **Editor** (menú *Usuarios*).

## 6. Activar la licencia de Kirby

En el panel, abajo a la izquierda, **Activate** → correo y clave de licencia.
Se guarda en `site/config/.license` (en el servidor; no va a git).

## 7. Comprobar el correo del formulario

1. En el panel → *Formulario*: revisa el correo destinatario.
2. Envía un mensaje de prueba desde `/en/contact`.
3. Si no llega o va a spam, configura SMTP: copia
   `site/config/config.mrcconsulting.es.example.php` como
   `config.mrcconsulting.es.php` (y `config.www.mrcconsulting.es.php`) con los datos del
   buzón. El remitente (`web@mrcconsulting.es`) debe existir o estar permitido en IONOS.

## 8. Activar el doble factor (recomendado)

Cuando el correo funcione, en `site/config/config.php`:

```php
'password' => ['2fa' => true],
```

Cada persona recibirá un código por correo al entrar (o podrá configurar una app de
autenticación en *Tu cuenta*).

## 9. Últimas comprobaciones

- [ ] `https://mrcconsulting.es` redirige a `/en` o `/es`.
- [ ] Direcciones antiguas redirigen: `/tarifas`, `/politica-privacidad`, `/blog`.
- [ ] `https://mrcconsulting.es/sitemap.xml` y `/robots.txt` responden.
- [ ] `https://mrcconsulting.es/content/home/home.en.txt` devuelve **error** (bloqueado).
- [ ] El formulario llega al buzón.
- [ ] Opcional: dar de alta `sitemap.xml` en Google Search Console.

## 10. La web antigua

Antes de borrar el WordPress, descarga una copia completa (archivos + base de datos).
Mientras siga en el servidor, el dominio ya no apunta a él, así que no es accesible
desde `mrcconsulting.es`.

---

## Copias de seguridad

Todo el contenido está en archivos: **copiar la carpeta = copia completa**. Como mínimo,
descarga periódicamente por SFTP:

- `content/` (textos e imágenes)
- `site/accounts/` (usuarios del panel)
- `site/config/` (configuración y licencia)

IONOS también hace copias automáticas del espacio web (según el plan contratado).

## Volver atrás

- **Toda la web**: en IONOS, vuelve a apuntar el dominio a la carpeta anterior.
- **Un contenido**: sube la carpeta de esa página desde la última copia de `content/`.

## Subir cambios de código más adelante

Sube solo los archivos de código cambiados (`site/`, `assets/`, `.htaccess`).
**Nunca** subas `content/`, `site/accounts/` ni `site/config/.license` desde tu ordenador
sin bajarlos antes del servidor.
