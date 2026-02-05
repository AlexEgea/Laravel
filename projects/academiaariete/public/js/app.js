// ========================================================
// MATRÍCULA (select curso, origen "Otros", tarifa, DNI/CP/Teléfono)
// ========================================================
document.addEventListener('DOMContentLoaded', function () {
  const selCurso   = document.getElementById('curso_matriculacion');
  const selOrigen  = document.getElementById('origen');
  const otrosWrap  = document.getElementById('origen-otros-wrap');
  const otrosInput = document.getElementById('origen_otros');
  const tarifaEl   = document.getElementById('tarifa_value');
  const dniInput   = document.getElementById('dni');
  const cpInput    = document.getElementById('cp');
  const telInput   = document.getElementById('telefono');

  function cursosAnteriorYActual() {
    const y = new Date().getFullYear();
    return { anterior: `${y - 1}/${y}`, actual: `${y}/${y + 1}` };
  }

  function poblarCursos() {
    if (!selCurso) return;
    const { anterior, actual } = cursosAnteriorYActual();
    Array.from(selCurso.querySelectorAll('option:not([disabled])')).forEach(o => o.remove());
    selCurso.add(new Option(anterior, anterior));
    selCurso.add(new Option(actual, actual));
    const initialCurso = selCurso.dataset.initial || null;
    selCurso.value = initialCurso || actual;
  }

  // usa data-nombre y data-requiere-detalle del <option>
  function toggleOtros() {
    if (!selOrigen || !otrosWrap || !otrosInput) return;

    const opt = selOrigen.options[selOrigen.selectedIndex];
    if (!opt) {
      otrosWrap.classList.add('hidden');
      otrosInput.required = false;
      otrosInput.value = '';
      return;
    }

    const requiereDetalle = opt.getAttribute('data-requiere-detalle') === '1';
    const nombre = (opt.getAttribute('data-nombre') || '').trim().toLowerCase();

    const mostrar = requiereDetalle || nombre === 'otros';

    otrosWrap.classList.toggle('hidden', !mostrar);
    otrosInput.required = mostrar && requiereDetalle;
    if (!mostrar) {
      otrosInput.value = '';
    }
  }

  function actualizarTarifa() {
    if (tarifaEl) tarifaEl.textContent = '20€';
  }

  // Solo dígitos, respetando maxLength si es > 0
  const onlyDigits = (el) => el && el.addEventListener('input', () => {
    const max = (typeof el.maxLength === 'number' && el.maxLength > 0) ? el.maxLength : 99;
    el.value = el.value.replace(/\D+/g, '').slice(0, max);
  });

  if (dniInput) {
    dniInput.addEventListener('input', () => {
      dniInput.value = dniInput.value.replace(/\s+/g, '').toUpperCase();
    });
  }
  onlyDigits(cpInput);
  onlyDigits(telInput);

  poblarCursos();
  actualizarTarifa();
  toggleOtros();

  if (selOrigen) selOrigen.addEventListener('change', toggleOtros);
  if (selCurso)  selCurso.addEventListener('change', actualizarTarifa);

  // Scroll al primer campo inválido
  const firstInvalid = document.querySelector('.is-invalid');
  if (firstInvalid) {
    firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
    try { firstInvalid.focus({ preventScroll: true }); } catch (_) {}
  }
});

// ========================================================
// Mostrar nombre(s) de archivo en Matriculación (justificante/adjuntos/imagen noticia)
// + Contacto (adjunto único)
// ========================================================
document.addEventListener('DOMContentLoaded', () => {
  function bindFileName(inputId, spanId) {
    const input = document.getElementById(inputId);
    let span = document.getElementById(spanId);
    if (!input) return;

    if (!span) {
      const wrap = document.createElement('div');
      wrap.className = 'mt-1';
      span = document.createElement('div');
      span.id = spanId;
      span.className = 'file-msg';
      wrap.appendChild(span);
      const inlineWrap = input.closest('.file-inline');
      if (inlineWrap && inlineWrap.parentNode) {
        inlineWrap.parentNode.insertBefore(wrap, inlineWrap.nextSibling);
      } else if (input.parentNode) {
        input.parentNode.appendChild(wrap);
      }
    }

    function setText(files) {
      const text = (!files || files.length === 0)
        ? 'Ningún archivo seleccionado'
        : Array.from(files).map(f => f.name).join(', ');
      span.textContent = text;
      span.title = text;
      span.setAttribute('aria-label', text);
    }

    setText(input.files);
    input.addEventListener('change', () => setText(input.files));
  }

  bindFileName('justificante', 'justificante_name');
  bindFileName('adjuntos', 'adjuntos_name');
  // Para la imagen destacada de la noticia
  bindFileName('imagen', 'imagen_name');
  // Formulario de contacto (adjunto único)
  bindFileName('adjunto', 'fileName');
});

// ========================================================
// TRABAJA CON NOSOTROS: alternar áreas por perfil
// ========================================================
document.addEventListener('DOMContentLoaded', () => {
  const perfilRadios = document.querySelectorAll('input[name="perfil"]');
  const areasDocente = document.getElementById('areas_docente');
  const areasNoDoc   = document.getElementById('areas_no_docente');

  function toggleAreas() {
    const checked = document.querySelector('input[name="perfil"]:checked');
    const val = checked ? checked.value : 'docente';
    if (areasDocente) areasDocente.classList.toggle('hidden', val !== 'docente');
    if (areasNoDoc)   areasNoDoc.classList.toggle('hidden', val !== 'no_docente');
    const lDoc = document.querySelector('label[for="perfil_docente"]');
    const lNo  = document.querySelector('label[for="perfil_no_docente"]');
    if (lDoc) lDoc.setAttribute('tabindex', val === 'docente' ? '0' : '-1');
    if (lNo)  lNo.setAttribute('tabindex', val === 'no_docente' ? '0' : '-1');
  }

  if (perfilRadios.length) {
    perfilRadios.forEach(r => r.addEventListener('change', toggleAreas));
    toggleAreas();
  }
});

// ========================================================
// HOME: Carrusel principal (autoplay, pausa en hover del carrusel y flechas)
// ========================================================
document.addEventListener('DOMContentLoaded', () => {
  const root = document.getElementById('homeCarousel');
  if (!root) return;
  const track = root.querySelector('[data-carousel-track]');
  const dotsWrap = root.parentElement.querySelector('[data-carousel-dots]');
  const dots = Array.from(dotsWrap?.querySelectorAll('button.dot') || []);
  const btnPrev = root.parentElement.querySelector('[data-carousel-prev]');
  const btnNext = root.parentElement.querySelector('[data-carousel-next]');

  const slidesCount = track.children.length;
  let index = 0;
  let timer = null;
  const ROTATION_MS = 6000;
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function paintDots(activeIndex) {
    dots.forEach((d, k) => {
      const isActive = k === activeIndex;
      d.setAttribute('aria-selected', isActive ? 'true' : 'false');
      d.classList.toggle('bg-[var(--arietehover)]', isActive);
      d.classList.toggle('bg-slate-300', !isActive);
    });
  }

  function go(i) {
    index = (i + slidesCount) % slidesCount;
    track.style.transform = `translateX(-${index * 100}%)`;
    paintDots(index);
  }

  function next() { go(index + 1); }
  function prev() { go(index - 1); }

  function pause() {
    if (timer) clearInterval(timer);
    timer = null;
    root.dataset.paused = 'true';
  }

  function play() {
    if (prefersReducedMotion) return;
    if (timer) clearInterval(timer);
    timer = setInterval(next, ROTATION_MS);
    root.dataset.paused = 'false';
  }

  function restart() { pause(); play(); }

  // Click controls
  btnNext?.addEventListener('click', () => { next(); restart(); });
  btnPrev?.addEventListener('click', () => { prev(); restart(); });
  dots.forEach((d, k) => d.addEventListener('click', () => { go(k); restart(); }));

  // Pausa en hover del carrusel
  root.addEventListener('mouseenter', pause);
  root.addEventListener('mouseleave', play);

  // Pausa en hover de flechas
  [btnPrev, btnNext].forEach(btn => {
    btn?.addEventListener('mouseenter', pause);
    btn?.addEventListener('mouseleave', play);
  });

  // Teclado
  root.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowRight') { e.preventDefault(); next(); restart(); }
    if (e.key === 'ArrowLeft')  { e.preventDefault(); prev(); restart(); }
  });
  root.setAttribute('tabindex', '0');

  // Pausa si cambia pestaña
  window.addEventListener('visibilitychange', () => { if (document.hidden) pause(); else play(); });

  // Init
  paintDots(0);
  if (!prefersReducedMotion) play();
});

// ========================================================
// HOME: Carrusel de promociones (similar al principal)
// ========================================================
document.addEventListener('DOMContentLoaded', () => {
  const root = document.getElementById('promosCarousel');
  if (!root) return;

  const track = root.querySelector('[data-promos-track]');
  if (!track) return;

  // Controles fuera de la tarjeta → buscamos en todo el documento
  const dotsWrap = document.querySelector('[data-promos-dots]');
  const dots     = Array.from(dotsWrap?.querySelectorAll('button.promo-dot') || []);
  const btnPrev  = document.querySelector('[data-promos-prev]');
  const btnNext  = document.querySelector('[data-promos-next]');

  const slidesCount = track.children.length;
  if (!slidesCount || slidesCount <= 1) {
    // Si solo hay una promo, pintamos el primer dot activo y listo
    if (dots.length) {
      dots.forEach((d, k) => {
        const isActive = k === 0;
        d.setAttribute('aria-selected', isActive ? 'true' : 'false');
        d.classList.toggle('bg-[var(--arietehover)]', isActive);
        d.classList.toggle('bg-slate-300', !isActive);
      });
    }
    return;
  }

  let index = 0;
  let timer = null;
  const ROTATION_MS = 7000;
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function paintDots(activeIndex) {
    dots.forEach((d, k) => {
      const isActive = k === activeIndex;
      d.setAttribute('aria-selected', isActive ? 'true' : 'false');
      d.classList.toggle('bg-[var(--arietehover)]', isActive);
      d.classList.toggle('bg-slate-300', !isActive);
    });
  }

  function go(i) {
    index = (i + slidesCount) % slidesCount;
    track.style.transform = `translateX(-${index * 100}%)`;
    paintDots(index);
  }

  function next() { go(index + 1); }
  function prev() { go(index - 1); }

  function pause() {
    if (timer) clearInterval(timer);
    timer = null;
    root.dataset.paused = 'true';
  }

  function play() {
    if (prefersReducedMotion) return;
    if (timer) clearInterval(timer);
    timer = setInterval(next, ROTATION_MS);
    root.dataset.paused = 'false';
  }

  function restart() { pause(); play(); }

  // Click controls
  btnNext?.addEventListener('click', () => { next(); restart(); });
  btnPrev?.addEventListener('click', () => { prev(); restart(); });

  dots.forEach((d, k) => d.addEventListener('click', () => { go(k); restart(); }));

  // Pausa en hover del carrusel
  root.addEventListener('mouseenter', pause);
  root.addEventListener('mouseleave', play);

  // Pausa en hover de flechas
  [btnPrev, btnNext].forEach(btn => {
    btn?.addEventListener('mouseenter', pause);
    btn?.addEventListener('mouseleave', play);
  });

  // Teclado
  root.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowRight') { e.preventDefault(); next(); restart(); }
    if (e.key === 'ArrowLeft')  { e.preventDefault(); prev(); restart(); }
  });
  root.setAttribute('tabindex', '0');

  // Pausa si cambia pestaña
  window.addEventListener('visibilitychange', () => { if (document.hidden) pause(); else play(); });

  // Init
  paintDots(0);
  if (!prefersReducedMotion) play();
});

// ========================================================
// ADMIN NOTICIAS: editor de contenido con botones de formato
// ========================================================
(function () {
  function getTextarea() {
    return document.getElementById('contenido');
  }

  function applyTag(tagOpen, tagClose, placeholder = '') {
    const formato = getTextarea();
    if (!formato) return;

    formato.focus();

    const start = formato.selectionStart ?? 0;
    const end   = formato.selectionEnd ?? 0;

    const before   = formato.value.substring(0, start);
    const selected = formato.value.substring(start, end);
    const text     = selected || placeholder;

    formato.value =
      before + tagOpen + text + tagClose + formato.value.substring(end);

    const cursorStart = before.length + tagOpen.length;
    const cursorEnd   = cursorStart + text.length;
    formato.setSelectionRange(cursorStart, cursorEnd);
  }

  function insertSubtitulo() {
    applyTag('<h3 class="subtitulo">', '</h3>', 'Título de sección');
  }

  function insertNegrita() {
    applyTag('<strong>', '</strong>', 'texto en negrita');
  }

  function insertCursiva() {
    applyTag('<em>', '</em>', 'texto en cursiva');
  }

  function insertLista(tipo = 'ul') {
    const formato = getTextarea();
    if (!formato) return;

    formato.focus();

    const start = formato.selectionStart ?? 0;
    const end   = formato.selectionEnd ?? 0;

    const before   = formato.value.substring(0, start);
    const selected = formato.value.substring(start, end);

    let bloqueLista = '';

    if (selected && selected.trim().length) {
      const lines = selected.replace(/\r\n/g, '\n').split('\n');
      const items = lines
        .map(l => l.trim())
        .filter(l => l.length)
        .map(l => `  <li>${l}</li>`)
        .join('\n');

      bloqueLista = `<${tipo}>\n${items}\n</${tipo}>\n`;
    } else {
      bloqueLista =
        tipo === 'ol'
          ? '<ol>\n  <li>Primer elemento</li>\n  <li>Segundo elemento</li>\n</ol>\n'
          : '<ul>\n  <li>Primer elemento</li>\n  <li>Segundo elemento</li>\n</ul>\n';
    }

    formato.value =
      before + bloqueLista + formato.value.substring(end);

    const cursorPos = before.length + bloqueLista.length;
    formato.setSelectionRange(cursorPos, cursorPos);
  }

  function insertEnlace() {
    const formato = getTextarea();
    if (!formato) return;

    const url = prompt('Introduce la URL del enlace:', 'https://');
    if (!url || !url.trim()) return;

    formato.focus();

    const start = formato.selectionStart ?? 0;
    const end   = formato.selectionEnd ?? 0;
    const selected = formato.value.substring(start, end);

    let placeholder = selected.trim();
    if (!placeholder) {
      const texto = prompt('Texto del enlace (opcional):', 'Texto del enlace');
      if (texto && texto.trim()) {
        placeholder = texto.trim();
      } else {
        placeholder = url.trim();
      }
    }

    const tagOpen = `<a href="${url.trim()}" target="_blank" rel="noopener">`;
    applyTag(tagOpen, '</a>', placeholder);
  }

  window.insertSubtitulo = insertSubtitulo;
  window.insertNegrita   = insertNegrita;
  window.insertCursiva   = insertCursiva;
  window.insertLista     = insertLista;
  window.insertEnlace    = insertEnlace;
})();

// ========================================================
// ADMIN NOTICIAS: categorías (buscador + borrar)
// ========================================================
document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('categoria_search');
  const grupos      = document.querySelectorAll('#categorias-list .categoria-group');

  if (searchInput && grupos.length) {
    searchInput.addEventListener('input', () => {
      const term = searchInput.value
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
        .toLowerCase()
        .trim();

      grupos.forEach(group => {
        const pills   = group.querySelectorAll('.categoria-pill');
        let visibleInGroup = 0;

        pills.forEach(pill => {
          const nombre = (pill.dataset.categoriaNombre || '')
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .toLowerCase();

          const show = !term || nombre.includes(term);
          pill.classList.toggle('hidden', !show);
          if (show) visibleInGroup++;
        });

        group.classList.toggle('hidden', visibleInGroup === 0);
      });
    });
  }
});

// Helper para CSRF de Laravel
function getCsrfToken() {
  const meta = document.querySelector('meta[name="csrf-token"]');
  return meta ? meta.getAttribute('content') : '';
}

// --- Borrado de categorías desde el botón ✕ ---
function handleDeleteCategoria(button) {
  if (!button) return;

  const id     = button.dataset.categoriaId;
  const nombre = button.dataset.categoriaNombre || '';

  if (!id) return;

  const mensaje = nombre
    ? `¿Seguro que quieres borrar la categoría "${nombre}"?\n\nSe desvinculará de todas las noticias.`
    : '¿Seguro que quieres borrar esta categoría? Se desvinculará de todas las noticias.';

  if (!window.confirm(mensaje)) {
    return;
  }

  let form = document.getElementById('delete-categoria-form');
  if (!form) {
    form = document.createElement('form');
    form.id = 'delete-categoria-form';
    form.method = 'POST';
    form.className = 'hidden';

    const token = getCsrfToken();
    if (token) {
      const inputToken = document.createElement('input');
      inputToken.type = 'hidden';
      inputToken.name = '_token';
      inputToken.value = token;
      form.appendChild(inputToken);
    }

    const inputMethod = document.createElement('input');
    inputMethod.type = 'hidden';
    inputMethod.name = '_method';
    inputMethod.value = 'DELETE';
    form.appendChild(inputMethod);

    document.body.appendChild(form);
  }

  form.action = `/admin/categorias/${id}`;
  form.submit();
}

// ========================================================
// ADMIN OPOSICIONES: editor de descripción con botones de formato
// ========================================================
(function () {
  function getTextareaDescripcion() {
    return document.getElementById('descripcion');
  }

  function applyTagDescripcion(tagOpen, tagClose, placeholder = '') {
    const textarea = getTextareaDescripcion();
    if (!textarea) return;

    textarea.focus();

    const start = textarea.selectionStart ?? 0;
    const end   = textarea.selectionEnd ?? 0;

    const before   = textarea.value.substring(0, start);
    const selected = textarea.value.substring(start, end);
    const text     = selected || placeholder;

    textarea.value =
      before + tagOpen + text + tagClose + textarea.value.substring(end);

    const cursorStart = before.length + tagOpen.length;
    const cursorEnd   = cursorStart + text.length;
    textarea.setSelectionRange(cursorStart, cursorEnd);
  }

  function insertSubtituloDescripcion() {
    applyTagDescripcion('<h3 class="subtitulo">', '</h3>', 'Título de sección');
  }

  function insertNegritaDescripcion() {
    applyTagDescripcion('<strong>', '</strong>', 'texto en negrita');
  }

  function insertCursivaDescripcion() {
    applyTagDescripcion('<em>', '</em>', 'texto en cursiva');
  }

  function insertListaDescripcion(tipo = 'ul') {
    const textarea = getTextareaDescripcion();
    if (!textarea) return;

    textarea.focus();

    const start = textarea.selectionStart ?? 0;
    const end   = textarea.selectionEnd ?? 0;

    const before   = textarea.value.substring(0, start);
    const selected = textarea.value.substring(start, end);

    let bloqueLista = '';

    if (selected && selected.trim().length) {
      const lines = selected.replace(/\r\n/g, '\n').split('\n');
      const items = lines
        .map(l => l.trim())
        .filter(l => l.length)
        .map(l => `  <li>${l}</li>`)
        .join('\n');

      bloqueLista = `<${tipo}>\n${items}\n</${tipo}>\n`;
    } else {
      bloqueLista =
        tipo === 'ol'
          ? '<ol>\n  <li>Primer elemento</li>\n  <li>Segundo elemento</li>\n</ol>\n'
          : '<ul>\n  <li>Primer elemento</li>\n  <li>Segundo elemento</li>\n</ul>\n';
    }

    textarea.value =
      before + bloqueLista + textarea.value.substring(end);

    const cursorPos = before.length + bloqueLista.length;
    textarea.setSelectionRange(cursorPos, cursorPos);
  }

  function insertEnlaceDescripcion() {
    const textarea = getTextareaDescripcion();
    if (!textarea) return;

    const url = prompt('Introduce la URL del enlace:', 'https://');
    if (!url || !url.trim()) return;

    textarea.focus();

    const start = textarea.selectionStart ?? 0;
    const end   = textarea.selectionEnd ?? 0;
    const selected = textarea.value.substring(start, end);

    let placeholder = selected.trim();
    if (!placeholder) {
      const texto = prompt('Texto del enlace (opcional):', 'Texto del enlace');
      if (texto && texto.trim()) {
        placeholder = texto.trim();
      } else {
        placeholder = url.trim();
      }
    }

    const tagOpen = `<a href="${url.trim()}" target="_blank" rel="noopener">`;
    applyTagDescripcion(tagOpen, '</a>', placeholder);
  }

  window.insertSubtituloDescripcion = insertSubtituloDescripcion;
  window.insertNegritaDescripcion   = insertNegritaDescripcion;
  window.insertCursivaDescripcion   = insertCursivaDescripcion;
  window.insertListaDescripcion     = insertListaDescripcion;
  window.insertEnlaceDescripcion    = insertEnlaceDescripcion;
})();

// ========================================================
// ADMIN OPOSICIONES: buscador de ramas padre
// ========================================================
document.addEventListener('DOMContentLoaded', () => {
  const searchInput = document.getElementById('rama_search');
  const pills       = document.querySelectorAll('#ramas-list .rama-pill');

  if (!searchInput || !pills.length) return;

  searchInput.addEventListener('input', () => {
    const term = searchInput.value
      .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
      .toLowerCase()
      .trim();

    pills.forEach(pill => {
      const nombre = (pill.dataset.ramaNombre || '')
        .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
        .toLowerCase();

      const show = !term || nombre.includes(term);
      pill.style.display = show ? 'inline-flex' : 'none';
    });
  });
});

// ========================================================
// OPOSICIONES (SHOW): carrusel de pestañas en la vista pública
// ========================================================
document.addEventListener('DOMContentLoaded', () => {
  const container = document.querySelector('[data-oposicion-tabs]');
  if (!container) return;

  const buttons = Array.from(container.querySelectorAll('[data-tab-button]'));
  const panels  = Array.from(container.querySelectorAll('[data-tab-panel]'));

  function activarTab(targetId) {
    // Mostrar/ocultar paneles
    panels.forEach(panel => {
      if (panel.id === targetId) {
        panel.classList.remove('hidden');
      } else {
        panel.classList.add('hidden');
      }
    });

    // Actualizar estado de los botones
    buttons.forEach(btn => {
      const isActive = btn.dataset.target === targetId;
      btn.dataset.active = isActive ? 'true' : 'false';
      btn.setAttribute('aria-selected', isActive ? 'true' : 'false');
    });
  }

  // Click en cada botón
  buttons.forEach(btn => {
    btn.addEventListener('click', () => {
      const targetId = btn.dataset.target;
      activarTab(targetId);
    });
  });

  // Activar la primera pestaña (Información) por defecto
  if (buttons.length && buttons[0].dataset.target) {
    activarTab(buttons[0].dataset.target);
  }
});

// HEADER: MENÚ MÓVIL DESPLEGABLE DESDE LA DERECHA
document.addEventListener('DOMContentLoaded', () => {
  const toggleBtn  = document.querySelector('[data-menu-toggle]');
  const panel      = document.querySelector('[data-menu-panel]');
  const backdrop   = document.querySelector('[data-menu-backdrop]');
  const closeBtn   = document.querySelector('[data-menu-close]');

  if (!toggleBtn || !panel || !backdrop) return;

  const panelLinks = panel.querySelectorAll('a[href]');

  const openMenu = () => {
    panel.classList.remove('translate-x-full');
    backdrop.classList.remove('opacity-0', 'pointer-events-none');
    toggleBtn.setAttribute('aria-expanded', 'true');
    panel.setAttribute('aria-hidden', 'false');
  };

  const closeMenu = () => {
    panel.classList.add('translate-x-full');
    backdrop.classList.add('opacity-0', 'pointer-events-none');
    toggleBtn.setAttribute('aria-expanded', 'false');
    panel.setAttribute('aria-hidden', 'true');
  };

  // Estado inicial: cerrado
  closeMenu();

  toggleBtn.addEventListener('click', () => {
    const isOpen = !panel.classList.contains('translate-x-full');
    if (isOpen) {
      closeMenu();
    } else {
      openMenu();
    }
  });

  backdrop.addEventListener('click', closeMenu);
  if (closeBtn) closeBtn.addEventListener('click', closeMenu);

  // Cerrar al pulsar Escape
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeMenu();
  });

  // Cerrar al hacer clic en cualquier enlace del panel
  panelLinks.forEach(link => {
    link.addEventListener('click', () => {
      closeMenu();
    });
  });
});
