/**
 * Dark Mode Manager - Gestión unificada del modo oscuro
 * Consolida toda la lógica de dark mode en un módulo centralizado
 */

class DarkModeManager {
  constructor() {
    this.STORAGE_KEY = 'darkMode';
    this.DARK_CLASS = 'dark';
    this.TOGGLE_BUTTON_ID = 'toggleDarkMode';
    
    // Referencias a elementos
    this.body = document.body;
    this.toggleButton = null;
    this.logoElement = null;
    
    // Bindings
    this.handleToggle = this.handleToggle.bind(this);
    this.handleMutation = this.handleMutation.bind(this);
    
    // Inicializar
    this.init();
  }

  /**
   * Inicializa el dark mode manager
   */
  init() {
    // Aplicar tema guardado inmediatamente para evitar flash
    this.applyStoredTheme();
    
    // Configurar cuando el DOM esté listo
    if (document.readyState === 'loading') {
      document.addEventListener('DOMContentLoaded', () => this.setupElements());
    } else {
      this.setupElements();
    }
  }

  /**
   * Aplica el tema guardado inmediatamente
   */
  applyStoredTheme() {
    const isDarkMode = this.getStoredTheme();
    if (isDarkMode) {
      this.body.classList.add(this.DARK_CLASS);
    }
  }

  /**
   * Obtiene el tema guardado en localStorage
   */
  getStoredTheme() {
    return localStorage.getItem(this.STORAGE_KEY) === '1';
  }

  /**
   * Guarda el tema en localStorage
   */
  saveTheme(isDark) {
    localStorage.setItem(this.STORAGE_KEY, isDark ? '1' : '0');
  }

  /**
   * Configura los elementos del DOM
   */
  setupElements() {
    // Configurar botón de toggle
    this.toggleButton = document.getElementById(this.TOGGLE_BUTTON_ID);
    if (this.toggleButton) {
      this.toggleButton.addEventListener('click', this.handleToggle);
      // Establecer icono inicial
      this.updateToggleIcon(this.body.classList.contains(this.DARK_CLASS));
    }

    // Configurar logo
    this.logoElement = document.getElementById('logoEntidad');
    
    // Establecer logo inicial inmediatamente (sin esperar dark mode)
    this.setInitialLogo();
    
    // Configurar observer para cambios
    this.setupMutationObserver();
    
    // Actualizar logo según dark mode actual
    this.updateLogo();
    
    console.log('[DarkMode] Inicializado correctamente');
  }

  /**
   * Establece el logo inicial según la entidad
   */
  setInitialLogo() {
    if (!this.logoElement) return;
    
    const entidad = localStorage.getItem('lastLoginCountry');
    
    // Detectar si estamos en subdirectorio pages/ o en root
    const isInPages = window.location.pathname.includes('/pages/');
    const assetsPath = isInPages ? '../assets/' : 'assets/';
    const timestamp = `?v=${new Date().getTime()}`;
    
    if (entidad === 'ar' || entidad === 'uy' || entidad === 'py') {
      this.logoElement.src = assetsPath + 'logo_fondoblanco.png' + timestamp;
      this.logoElement.alt = 'Logo EDDIS';
    } else if (entidad === 'sb') {
      this.logoElement.src = assetsPath + 'logo-studio-blanco.png' + timestamp;
      this.logoElement.alt = 'Logo Studio Beauty';
    } else {
      this.logoElement.src = assetsPath + 'logo_fondoblanco.png' + timestamp;
      this.logoElement.alt = 'Logo Eddis';
    }
  }

  /**
   * Maneja el toggle del dark mode
   */
  handleToggle() {
    const isDarkMode = this.body.classList.toggle(this.DARK_CLASS);
    this.saveTheme(isDarkMode);
    
    // Actualizar ícono del botón
    this.updateToggleIcon(isDarkMode);
    
    console.log(`[DarkMode] Cambiado a ${isDarkMode ? 'oscuro' : 'claro'}`);
  }

  /**
   * Configura el mutation observer para detectar cambios
   */
  setupMutationObserver() {
    const observer = new MutationObserver(this.handleMutation);
    observer.observe(this.body, { 
      attributes: true, 
      attributeFilter: ['class'] 
    });
  }

  /**
   * Maneja las mutaciones del DOM
   */
  handleMutation(mutations) {
    mutations.forEach(mutation => {
      if (mutation.attributeName === 'class') {
        this.updateLogo();
      }
    });
  }

  /**
   * Actualiza el logo según el modo actual
   */
  updateLogo() {
    if (!this.logoElement) return;
    
    const isDarkMode = this.body.classList.contains(this.DARK_CLASS);
    const entidad = localStorage.getItem('lastLoginCountry');
    
    // Detectar si estamos en subdirectorio pages/ o en root
    const isInPages = window.location.pathname.includes('/pages/');
    const assetsPath = isInPages ? '../assets/' : 'assets/';
    const timestamp = `?v=${new Date().getTime()}`;
    
    if (entidad === 'ar' || entidad === 'uy' || entidad === 'py') {
      this.logoElement.src = isDarkMode 
        ? assetsPath + 'logo_eddis_dark.png' + timestamp
        : assetsPath + 'logo_fondoblanco.png' + timestamp;
      this.logoElement.alt = 'Logo EDDIS';
    } else if (entidad === 'sb') {
      this.logoElement.src = isDarkMode 
        ? assetsPath + 'logo_studio_dark.png' + timestamp
        : assetsPath + 'logo-studio-blanco.png' + timestamp;
      this.logoElement.alt = 'Logo Studio Beauty';
    } else {
      this.logoElement.src = isDarkMode 
        ? assetsPath + 'logo_eddis_dark.png' + timestamp
        : assetsPath + 'logo_fondoblanco.png' + timestamp;
      this.logoElement.alt = 'Logo Eddis';
    }
  }

  /**
   * Actualiza el ícono del botón toggle
   */
  updateToggleIcon(isDarkMode) {
    if (!this.toggleButton) return;
    
    const icon = this.toggleButton.querySelector('i');
    if (icon) {
      icon.className = isDarkMode 
        ? 'fa-solid fa-sun' 
        : 'fa-solid fa-moon';
    }
  }

  /**
   * Obtiene el estado actual del dark mode
   */
  isDarkMode() {
    return this.body.classList.contains(this.DARK_CLASS);
  }

  /**
   * Fuerza un modo específico
   */
  setDarkMode(isDark) {
    if (isDark) {
      this.body.classList.add(this.DARK_CLASS);
    } else {
      this.body.classList.remove(this.DARK_CLASS);
    }
    this.saveTheme(isDark);
    this.updateToggleIcon(isDark);
  }

  /**
   * Destruye el manager y limpia eventos
   */
  destroy() {
    if (this.toggleButton) {
      this.toggleButton.removeEventListener('click', this.handleToggle);
    }
  }
}

// Instancia global
let darkModeManager = null;

// Función de inicialización para compatibilidad
function initializeDarkMode() {
  if (!darkModeManager) {
    darkModeManager = new DarkModeManager();
  }
  return darkModeManager;
}

// Auto-inicializar
darkModeManager = new DarkModeManager();

// Exportar para uso global
window.DarkModeManager = DarkModeManager;
window.darkModeManager = darkModeManager;
window.initializeDarkMode = initializeDarkMode;