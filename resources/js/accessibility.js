(function () {
  const KEY = "a11y-settings:v1";
  const defaults = { fontSize: 100, highContrast: false, dyslexia: false, reduceMotion: false };

  function load() {
    try {
      const raw = localStorage.getItem(KEY);
      return raw ? Object.assign({}, defaults, JSON.parse(raw)) : Object.assign({}, defaults);
    } catch {
      return Object.assign({}, defaults);
    }
  }

  function save(s) {
    try { localStorage.setItem(KEY, JSON.stringify(s)); } catch {}
  }

  function apply(s) {
    const root = document.documentElement;
    root.style.fontSize = s.fontSize + "%";
    root.classList.toggle("a11y-contrast", !!s.highContrast);
    root.classList.toggle("a11y-dyslexia", !!s.dyslexia);
    root.classList.toggle("a11y-reduce-motion", !!s.reduceMotion);
  }

  function updateButtonsState(s, container) {
    const map = {
      contrast: s.highContrast,
      dyslexia: s.dyslexia,
      motion: s.reduceMotion
    };
    container.querySelectorAll("button[data-action]").forEach(btn => {
      const action = btn.getAttribute("data-action");
      if (action in map) {
        btn.setAttribute("aria-pressed", map[action] ? "true" : "false");
      }
    });
  }

  function init() {
    const settings = load();
    apply(settings);

    // delegación de eventos
    document.addEventListener("click", function (ev) {
      const btn = ev.target.closest && ev.target.closest("button[data-action]");
      if (!btn) return;
      const action = btn.getAttribute("data-action");
      if (!action) return;

      if (action === "inc") settings.fontSize = Math.min(150, settings.fontSize + 10);
      if (action === "dec") settings.fontSize = Math.max(80, settings.fontSize - 10);
      if (action === "contrast") settings.highContrast = !settings.highContrast;
      if (action === "dyslexia") settings.dyslexia = !settings.dyslexia;
      if (action === "motion") settings.reduceMotion = !settings.reduceMotion;
      if (action === "reset") Object.assign(settings, defaults);

      apply(settings);
      save(settings);

      // actualizar estados aria-pressed
      const container = document.querySelector(".a11y-controls");
      if (container) updateButtonsState(settings, container);
    });

    // Al cargar, asegurar que los botones reflejen el estado
    const controls = document.querySelector(".a11y-controls");
    if (controls) updateButtonsState(settings, controls);
  }

  // Inicia cuando DOM listo
  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", init);
  } else {
    init();
  }
})();