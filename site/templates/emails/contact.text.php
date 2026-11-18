<?php
/**
 * Correo que recibe MR&C cuando alguien envía el formulario de contacto.
 * Lo envía site/controllers/contact.php. Texto plano, sin HTML.
 */
?>
Nuevo mensaje desde la web de MR&C Consulting
==============================================

Nombre:                <?= $name ?>

Correo:                <?= $email ?>

Teléfono:              <?= $phone ?: '—' ?>


Tipo de organización:  <?= $orgType ?: '—' ?>

Organización:          <?= $orgName ?: '—' ?>

Tipo de estudio:       <?= $studyType ?: '—' ?>

Número de centros:     <?= $sites ?: '—' ?>

Fase del proyecto:     <?= $stage ?: '—' ?>

Tema:                  <?= $topicLabel ?: '—' ?>


Mensaje:
<?= $message ?>


----------------------------------------------
Idioma: <?= $language ?> · Página: <?= $pageUrl ?>

Para contestar, responde directamente a este correo.
