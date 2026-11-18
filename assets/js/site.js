/* =====================================================================
   JavaScript de la web (mínimo, sin librerías).
   La web funciona sin él; solo mejora:
     1. El botón ☰ del menú en móvil
     2. Preseleccionar el tema del formulario con ?topic=… en la
        vista previa estática (en el servidor real lo hace PHP)
   ===================================================================== */

// Indica al CSS que JavaScript está disponible (ver .no-js en 03-layout.css)
document.documentElement.classList.replace('no-js', 'js');

document.addEventListener('DOMContentLoaded', () => {

  // --- 1. Menú del móvil ----------------------------------------------
  const toggle = document.querySelector('.nav-toggle');
  const nav = document.getElementById('site-nav');

  if (toggle && nav) {
    const label = toggle.querySelector('.visually-hidden');

    const setOpen = (open) => {
      nav.classList.toggle('is-open', open);
      toggle.setAttribute('aria-expanded', String(open));
      if (label) {
        label.textContent = open ? toggle.dataset.labelClose : toggle.dataset.labelOpen;
      }
    };

    toggle.addEventListener('click', () => {
      setOpen(toggle.getAttribute('aria-expanded') !== 'true');
    });

    // Cerrar con la tecla Escape
    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape' && nav.classList.contains('is-open')) {
        setOpen(false);
        toggle.focus();
      }
    });

    // Cerrar al pulsar un enlace del menú (útil con anclas #seccion)
    nav.querySelectorAll('a').forEach((link) => {
      link.addEventListener('click', () => setOpen(false));
    });
  }

  // --- 2. Tema del formulario desde la dirección (?topic=monitoring) --
  const topicSelect = document.getElementById('f-topic');
  const topic = new URLSearchParams(window.location.search).get('topic');

  if (topicSelect && topic && !topicSelect.value) {
    const option = Array.from(topicSelect.options).find((o) => o.value === topic);
    if (option) {
      topicSelect.value = topic;
    }
  }
});
