/**
 * Sistema de Chatbot Configurable
 * @description Sistema de ayuda interactivo con temas expandibles y conexión a WhatsApp
 */

class Chatbot {
    constructor(config = {}) {
        this.config = {
            whatsappNumber: config.whatsappNumber || '5491112345678',
            whatsappMessage: config.whatsappMessage || '¡Hola! Necesito ayuda con la plataforma educativa.',
            title: config.title || 'Asistente Virtual',
            subtitle: config.subtitle || 'Estamos aquí para ayudarte',
            configUrl: config.configUrl || './js/chatbot-config.json',
            autoUpdateInterval: config.autoUpdateInterval || 30000, // 30 segundos por defecto
            ...config
        };

        this.topics = [];
        this.filteredTopics = [];
        this.isOpen = false;
        this.lastUpdate = null;
        this.updateTimer = null;
        
        this.init();
    }

    async init() {
        // Renderizar inmediatamente para que el FAB esté disponible aunque la config tarde en cargar
        try {
            this.render();
        } catch (err) {
            console.error('Chatbot: error durante render():', err);
        }

        // Asegurar que Font Awesome esté disponible (si no, intentar cargar localmente)
        this.ensureFontAwesomeLoaded().catch(err => console.warn('Chatbot: FA load warning', err));

        // Adjuntar listeners y arrancar auto-update
        this.attachEventListeners();
        this.startAutoUpdate();

        // Cargar configuración en background y actualizar contenido cuando esté lista
        this.loadConfig().then(() => {
            try {
                this.updateChatbotContent();
            } catch (err) {
                console.error('Chatbot: error actualizando contenido tras cargar config:', err);
            }
        }).catch(err => {
            console.warn('Chatbot: no se pudo cargar configuración inicial:', err);
        });
    }

    /**
     * Comprueba si Font Awesome está cargado y, si no, intenta inyectar la hoja de estilos
     * local relativa a la ubicación del script (../../fontawesome/css/all.min.css).
     */
    async ensureFontAwesomeLoaded() {
        try {
            // Crear un elemento de prueba para leer el pseudo-elemento ::before
            const testEl = document.createElement('i');
            testEl.className = 'fas fa-comment';
            testEl.style.display = 'none';
            document.body.appendChild(testEl);

            const pseudo = window.getComputedStyle(testEl, '::before');
            const fontFamily = pseudo.getPropertyValue('font-family') || '';
            document.body.removeChild(testEl);

            const hasFA = /Font\s?Awesome|FontAwesome|fa[srlb]?/i.test(fontFamily);
            if (hasFA) return; // Ya está disponible

            // Calcular ruta relativa desde la ubicación del script
            let scriptSrc = (document.currentScript && document.currentScript.src) || (function() {
                const s = document.querySelector('script[src*="chatbot.js"]');
                return s ? s.src : location.href;
            })();

            const faUrl = new URL('../../fontawesome/css/all.min.css', scriptSrc).href;

            // Inyectar link al CSS local
            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = faUrl;
            document.head.appendChild(link);

            // Esperar brevemente a que cargue (no bloquear demasiado si falla)
            await new Promise(resolve => {
                link.onload = () => resolve();
                // Timeout de 2s
                setTimeout(() => resolve(), 2000);
            });

            console.log('Chatbot: se intentó cargar Font Awesome local desde', faUrl);
        } catch (err) {
            console.warn('Chatbot: error comprobando/cargando Font Awesome:', err);
        }
    }

    /**
     * Inicia la actualización automática periódica
     */
    startAutoUpdate() {
        // Limpiar timer anterior si existe
        if (this.updateTimer) {
            clearInterval(this.updateTimer);
        }
        
        // Configurar actualización periódica
        this.updateTimer = setInterval(async () => {
            await this.checkAndUpdate();
        }, this.config.autoUpdateInterval);
        
        console.log(`Chatbot: Auto-actualización activada cada ${this.config.autoUpdateInterval/1000} segundos`);
    }

    /**
     * Verifica si hay actualizaciones y recarga el chatbot
     */
    async checkAndUpdate() {
        try {
            const cacheBuster = new Date().getTime();
            const url = `${this.config.configUrl}?v=${cacheBuster}`;
            
            const response = await fetch(url, {
                cache: 'no-cache',
                headers: {
                    'Cache-Control': 'no-cache',
                    'Pragma': 'no-cache'
                }
            });
            
            if (!response.ok) return;
            
            const data = await response.json();
            
            // Comparar si hay cambios (usando JSON.stringify para comparación simple)
            const currentData = JSON.stringify(this.topics);
            const newData = JSON.stringify(data.topics || []);
            
            if (currentData !== newData) {
                console.log('Chatbot: Nueva configuración detectada, actualizando...');
                
                // Guardar estado del chatbot
                const wasOpen = this.isOpen;
                const searchValue = document.getElementById('chatbot-search')?.value || '';
                
                // Guardar IDs de temas expandidos
                const expandedTopics = [];
                document.querySelectorAll('.chatbot-topic.expanded').forEach(topic => {
                    const topicId = topic.getAttribute('data-topic-id');
                    if (topicId) expandedTopics.push(topicId);
                });
                
                // Actualizar datos
                this.topics = data.topics || [];
                this.filteredTopics = this.topics;
                
                if (data.config) {
                    this.config = { ...this.config, ...data.config };
                }
                
                this.lastUpdate = new Date();
                
                // Re-renderizar solo si el chatbot está visible
                if (wasOpen) {
                    this.updateChatbotContent();
                    
                    // Restaurar temas expandidos
                    setTimeout(() => {
                        expandedTopics.forEach(topicId => {
                            const topic = document.querySelector(`[data-topic-id="${topicId}"]`);
                            if (topic) {
                                topic.classList.add('expanded');
                            }
                        });
                    }, 50); // Pequeño delay para asegurar que el DOM se actualizó
                    
                    // Restaurar búsqueda si había alguna
                    if (searchValue) {
                        const searchInput = document.getElementById('chatbot-search');
                        if (searchInput) {
                            searchInput.value = searchValue;
                            this.handleSearch(searchValue);
                        }
                    }
                }
            }
        } catch (error) {
            console.error('Error verificando actualizaciones del chatbot:', error);
        }
    }

    /**
     * Actualiza el contenido completo del chatbot
     */
    updateChatbotContent() {
        // Actualizar header
        this.updateHeader();
        
        // Actualizar contenido de temas
        const bodyElement = document.querySelector('.chatbot-body');
        if (bodyElement) {
            const welcomeHTML = this.renderWelcome();
            const topicsHTML = this.renderTopics();
            bodyElement.innerHTML = welcomeHTML + topicsHTML;
        }
        // No es necesario re-adjuntar eventos porque usamos delegación de eventos
    }

    /**
     * Actualiza el header del chatbot con la nueva configuración
     */
    updateHeader() {
        const headerTitle = document.querySelector('.chatbot-header h3');
        const headerSubtitle = document.querySelector('.chatbot-header p');
        
        if (headerTitle) headerTitle.textContent = this.config.title;
        if (headerSubtitle) headerSubtitle.textContent = this.config.subtitle;
    }

    async loadConfig() {
        try {
            // Cache busting: agregar timestamp para forzar recarga
            const cacheBuster = new Date().getTime();
            const url = `${this.config.configUrl}?v=${cacheBuster}`;
            
            const response = await fetch(url, {
                cache: 'no-cache',
                headers: {
                    'Cache-Control': 'no-cache',
                    'Pragma': 'no-cache'
                }
            });
            
            if (!response.ok) throw new Error('No se pudo cargar la configuración');
            
            const data = await response.json();
            this.topics = data.topics || [];
            this.filteredTopics = this.topics;
            
            // Actualizar configuración si viene en el JSON
            if (data.config) {
                this.config = { ...this.config, ...data.config };
            }
        } catch (error) {
            console.error('Error cargando configuración del chatbot:', error);
            this.topics = this.getDefaultTopics();
            this.filteredTopics = this.topics;
        }
    }

    getDefaultTopics() {
        return [
            {
                id: 'inicio',
                title: 'Primeros Pasos',
                icon: 'fa-rocket',
                questions: [
                    {
                        id: 'inicio-1',
                        question: '¿Cómo inicio sesión en la plataforma?',
                        answer: 'Para iniciar sesión necesitas tu número de legajo y tu documento de identidad. Ingresa estos datos en la pantalla de login y selecciona tu región (Argentina, Uruguay o Paraguay).'
                    },
                    {
                        id: 'inicio-2',
                        question: '¿Olvidé mi contraseña, qué hago?',
                        answer: 'Contacta con soporte técnico a través del botón "Soporte técnico" en la pantalla de login o envíanos un mensaje por WhatsApp para restablecer tus credenciales.'
                    }
                ]
            },
            {
                id: 'cursos',
                title: 'Mis Cursos',
                icon: 'fa-graduation-cap',
                questions: [
                    {
                        id: 'cursos-1',
                        question: '¿Dónde puedo ver mis cursos activos?',
                        answer: 'Una vez que inicies sesión, encontrarás todos tus cursos activos en el dashboard principal. Cada curso muestra tu progreso y las próximas actividades.'
                    },
                    {
                        id: 'cursos-2',
                        question: '¿Cómo accedo al material de estudio?',
                        answer: 'Dentro de cada curso encontrarás una sección de materiales donde podrás descargar PDFs, videos y otros recursos educativos.'
                    }
                ]
            },
            {
                id: 'evaluaciones',
                title: 'Evaluaciones y Tareas',
                icon: 'fa-clipboard-check',
                questions: [
                    {
                        id: 'eval-1',
                        question: '¿Cómo entrego una tarea?',
                        answer: 'Ingresa al curso correspondiente, busca la sección de tareas, selecciona la tarea que deseas entregar y sube tu archivo. No olvides hacer clic en "Enviar" para confirmar la entrega.'
                    },
                    {
                        id: 'eval-2',
                        question: '¿Puedo ver mis calificaciones?',
                        answer: 'Sí, todas tus calificaciones están disponibles en la sección "Mis Calificaciones" dentro de cada curso. También recibirás notificaciones cuando se publiquen nuevas notas.'
                    }
                ]
            },
            {
                id: 'tecnico',
                title: 'Soporte Técnico',
                icon: 'fa-wrench',
                questions: [
                    {
                        id: 'tech-1',
                        question: 'La plataforma no carga correctamente',
                        answer: 'Intenta limpiar la caché de tu navegador o prueba con otro navegador. Si el problema persiste, contacta con soporte técnico a través de WhatsApp.'
                    },
                    {
                        id: 'tech-2',
                        question: 'No puedo subir archivos',
                        answer: 'Verifica que el archivo no supere el tamaño máximo permitido (generalmente 10MB). Los formatos aceptados son: PDF, DOC, DOCX, JPG, PNG. Si el problema continúa, contacta con soporte.'
                    }
                ]
            },
            {
                id: 'contacto',
                title: 'Información de Contacto',
                icon: 'fa-phone',
                questions: [
                    {
                        id: 'contact-1',
                        question: '¿Cómo contacto con mi profesor?',
                        answer: 'Cada curso tiene una sección de mensajería donde puedes comunicarte directamente con tus profesores. También puedes enviar mensajes desde la sección "Contactos".'
                    },
                    {
                        id: 'contact-2',
                        question: '¿Cuál es el horario de atención?',
                        answer: 'El horario de atención al estudiante es de lunes a viernes de 9:00 a 18:00 hs. Para consultas urgentes fuera de horario, utiliza el botón de WhatsApp.'
                    }
                ]
            }
        ];
    }

    render() {
        const chatbotHTML = `
            <!-- Floating Action Button -->
            <button class="chatbot-fab" id="chatbotFab" aria-label="Abrir asistente virtual">
                <i class="fas fa-comment"></i>
                <i class="fas fa-times"></i>
            </button>

            <!-- Chatbot Container -->
            <div class="chatbot-container" id="chatbotContainer">
                <!-- Header -->
                <div class="chatbot-header">
                    <div class="chatbot-header-info">
                        <div class="chatbot-avatar">
                            <i class="fas fa-robot"></i>
                        </div>
                        <div class="chatbot-title">
                            <h3>${this.config.title}</h3>
                            <p>${this.config.subtitle}</p>
                        </div>
                    </div>
                    <button class="chatbot-close" id="chatbotClose" aria-label="Cerrar">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <!-- Search -->
                <div class="chatbot-search">
                    <div class="chatbot-search-wrapper">
                        <i class="fas fa-search chatbot-search-icon"></i>
                        <input 
                            type="text" 
                            class="chatbot-search-input" 
                            id="chatbotSearch"
                            placeholder="Buscar preguntas..."
                            aria-label="Buscar en el asistente"
                        >
                    </div>
                </div>

                <!-- Body -->
                <div class="chatbot-body" id="chatbotBody">
                    ${this.renderWelcome()}
                    ${this.renderTopics()}
                </div>

                <!-- Footer -->
                <!-- <div class="chatbot-footer">
                    <button class="chatbot-whatsapp-btn" id="chatbotWhatsapp">
                        <i class="fab fa-whatsapp"></i>
                        <span>Chatear por WhatsApp</span>
                    </button>
                </div> -->
            </div>
        `;

        // Insertar en el body
        document.body.insertAdjacentHTML('beforeend', chatbotHTML);
    }

    renderWelcome() {
        return `
            <div class="chatbot-welcome">
                <div class="chatbot-welcome-icon">
                    <i class="fas fa-comment-dots"></i>
                </div>
                <h4>¡Bienvenido!</h4>
                <p>Selecciona un tema o busca tu pregunta en el buscador</p>
            </div>
        `;
    }

    renderTopics() {
        if (this.filteredTopics.length === 0) {
            return this.renderNoResults();
        }

        const topicsHTML = this.filteredTopics.map(topic => `
            <div class="chatbot-topic" data-topic-id="${topic.id}">
                <div class="chatbot-topic-header">
                    <div class="chatbot-topic-title">
                        <div class="chatbot-topic-icon">
                            <i class="fas ${topic.icon}"></i>
                        </div>
                        <span>${topic.title}</span>
                    </div>
                    <i class="fas fa-chevron-down chatbot-topic-chevron"></i>
                </div>
                <div class="chatbot-topic-content">
                    <div class="chatbot-questions">
                        ${this.renderQuestions(topic.questions)}
                    </div>
                </div>
            </div>
        `).join('');

        return `<div class="chatbot-topics">${topicsHTML}</div>`;
    }

    renderQuestions(questions) {
        return questions.map(q => `
            <div class="chatbot-question" data-question-id="${q.id}">
                <div class="chatbot-question-title">
                    <i class="fas fa-circle"></i>
                    <span>${q.question}</span>
                </div>
                <div class="chatbot-answer">
                    <div class="chatbot-answer-content">
                        ${q.answer}
                    </div>
                </div>
            </div>
        `).join('');
    }

    renderNoResults() {
        return `
            <div class="chatbot-no-results">
                <i class="fas fa-search"></i>
                <h4>No se encontraron resultados</h4>
                <p>Intenta con otras palabras clave o contacta con soporte</p>
            </div>
        `;
    }

    attachEventListeners() {
        // Toggle chatbot
        const fab = document.getElementById('chatbotFab');
        const closeBtn = document.getElementById('chatbotClose');
        
        closeBtn?.addEventListener('click', () => this.close());

        // Mantener el botón fijo en la esquina inferior derecha.
        // No permitir arrastrar: forzamos posición fija y limpiamos cualquier posición previa guardada.
        if (fab) {
            fab.style.position = 'fixed';
            fab.style.right = '24px';
            fab.style.bottom = '24px';
            fab.style.left = 'auto';
            fab.style.top = 'auto';
            // En dispositivos móviles dejamos un poco más de espacio para no tapar el bottombar/perfil
            if (window.innerWidth <= 768) {
                fab.style.bottom = '110px';
                fab.style.right = '16px';
            }
            // Eliminar cualquier posición guardada en localStorage que pudiera mover el botón
            try { localStorage.removeItem('chatbotFabPosition'); } catch(e) {}

            // Asegurar que un click en el FAB abra/cierre el chatbot (antes la apertura dependía del dragEnd)
            fab.addEventListener('click', (e) => {
                // Evitar que el listener de documento cierre inmediatamente
                e.stopPropagation();
                this.toggle();
            });
        }

        // Search
        const searchInput = document.getElementById('chatbotSearch');
        searchInput?.addEventListener('input', (e) => this.handleSearch(e.target.value));

        // WhatsApp
        const whatsappBtn = document.getElementById('chatbotWhatsapp');
        whatsappBtn?.addEventListener('click', () => this.openWhatsApp());

        // Topics and questions (usar delegación de eventos)
        const chatbotBody = document.getElementById('chatbotBody');
        chatbotBody?.addEventListener('click', (e) => {
            const topicHeader = e.target.closest('.chatbot-topic-header');
            const question = e.target.closest('.chatbot-question');

            if (topicHeader) {
                const topic = topicHeader.closest('.chatbot-topic');
                this.toggleTopic(topic);
            } else if (question) {
                this.toggleQuestion(question);
            }
        });

        // Cerrar al hacer clic fuera
        document.addEventListener('click', (e) => {
            const container = document.getElementById('chatbotContainer');
            const fab = document.getElementById('chatbotFab');
            
            if (this.isOpen && 
                !container?.contains(e.target) && 
                !fab?.contains(e.target)) {
                this.close();
            }
        });

        // Cerrar con ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen) {
                this.close();
            }
        });
    }

    /**
     * Hace que el botón flotante sea arrastrable
     */
    makeDraggable(element) {
        if (!element) return;

        let active = false;
        let currentX;
        let currentY;
        let initialX;
        let initialY;
        let xOffset = 0;
        let yOffset = 0;
        let startTime;
        let moved = false;

        const isMobile = window.innerWidth <= 768;

        // Restaurar posición guardada solo en desktop
        if (!isMobile) {
            const savedPosition = localStorage.getItem('chatbotFabPosition');
            if (savedPosition) {
                try {
                    const pos = JSON.parse(savedPosition);
                    element.style.position = 'fixed';
                    element.style.left = pos.left + 'px';
                    element.style.top = pos.top + 'px';
                    element.style.right = 'auto';
                    element.style.bottom = 'auto';
                    xOffset = pos.left;
                    yOffset = pos.top;
                } catch (e) {
                    console.error('Error restaurando posición:', e);
                }
            }
        } else {
            // En móvil, limpiar cualquier posición guardada y resetear estilos
            localStorage.removeItem('chatbotFabPosition');
            element.style.position = '';
            element.style.left = '';
            element.style.top = '';
            element.style.right = '';
            element.style.bottom = '';
        }

        const dragStart = (e) => {
            // Solo activar si se toca el botón flotante directamente
            if (e.target.closest('#chatbotFab') !== element) return;
            
            startTime = Date.now();
            moved = false;

            if (e.type === "touchstart") {
                initialX = e.touches[0].clientX - xOffset;
                initialY = e.touches[0].clientY - yOffset;
            } else {
                initialX = e.clientX - xOffset;
                initialY = e.clientY - yOffset;
            }

            active = true;
            element.style.transition = 'none';
        };

        const dragEnd = (e) => {
            if (!active) return;

            const endTime = Date.now();
            const timeElapsed = endTime - startTime;

            initialX = currentX;
            initialY = currentY;
            active = false;
            element.style.transition = 'all 0.3s cubic-bezier(0.4, 0, 0.2, 1)';

            // Si fue un tap rápido sin movimiento, abrir chatbot
            if (!moved && timeElapsed < 200) {
                // Pequeño delay para asegurar que el evento se procesa correctamente
                requestAnimationFrame(() => {
                    this.toggle();
                });
            }

            // Guardar posición
            if (moved) {
                const rect = element.getBoundingClientRect();
                localStorage.setItem('chatbotFabPosition', JSON.stringify({
                    left: rect.left,
                    top: rect.top
                }));
            }

            moved = false;
        };

        const drag = (e) => {
            if (!active) return;

            e.preventDefault();

            if (e.type === "touchmove") {
                currentX = e.touches[0].clientX - initialX;
                currentY = e.touches[0].clientY - initialY;
            } else {
                currentX = e.clientX - initialX;
                currentY = e.clientY - initialY;
            }

            xOffset = currentX;
            yOffset = currentY;

            // Marcar como movido si superó umbral mínimo
            const deltaX = Math.abs(currentX - (xOffset || currentX));
            const deltaY = Math.abs(currentY - (yOffset || currentY));
            
            if (deltaX > 3 || deltaY > 3) {
                moved = true;
            }

            // Limitar dentro de la ventana
            const maxX = window.innerWidth - element.offsetWidth;
            const maxY = window.innerHeight - element.offsetHeight;

            currentX = Math.max(0, Math.min(currentX, maxX));
            currentY = Math.max(0, Math.min(currentY, maxY));

            setTranslate(currentX, currentY, element);
        };

        const setTranslate = (xPos, yPos, el) => {
            el.style.position = 'fixed';
            el.style.left = xPos + 'px';
            el.style.top = yPos + 'px';
            el.style.right = 'auto';
            el.style.bottom = 'auto';
        };

        // Touch events - en el elemento para start, en document para move/end
        element.addEventListener("touchstart", dragStart, false);
        document.addEventListener("touchend", dragEnd, false);
        document.addEventListener("touchmove", drag, false);

        // Mouse events - en el elemento para start, en document para move/end
        element.addEventListener("mousedown", dragStart, false);
        document.addEventListener("mouseup", dragEnd, false);
        document.addEventListener("mousemove", drag, false);
    }

    toggle() {
        if (this.isOpen) {
            this.close();
        } else {
            this.open();
        }
    }

    open() {
        const container = document.getElementById('chatbotContainer');
        const fab = document.getElementById('chatbotFab');
        
        container?.classList.add('active');
        fab?.classList.add('active');
        this.isOpen = true;

        // Focus en el buscador
        setTimeout(() => {
            document.getElementById('chatbotSearch')?.focus();
        }, 300);
    }

    close() {
        const container = document.getElementById('chatbotContainer');
        const fab = document.getElementById('chatbotFab');
        
        container?.classList.remove('active');
        fab?.classList.remove('active');
        this.isOpen = false;
    }

    toggleTopic(topicElement) {
        const isExpanded = topicElement.classList.contains('expanded');
        
        // Cerrar otros topics
        document.querySelectorAll('.chatbot-topic.expanded').forEach(topic => {
            if (topic !== topicElement) {
                topic.classList.remove('expanded');
            }
        });

        // Toggle el topic actual
        topicElement.classList.toggle('expanded');
    }

    toggleQuestion(questionElement) {
        const isExpanded = questionElement.classList.contains('expanded');
        
        // Cerrar otras preguntas del mismo topic
        const parentTopic = questionElement.closest('.chatbot-topic');
        parentTopic?.querySelectorAll('.chatbot-question.expanded').forEach(q => {
            if (q !== questionElement) {
                q.classList.remove('expanded');
            }
        });

        // Toggle la pregunta actual
        questionElement.classList.toggle('expanded');
    }

    handleSearch(query) {
        const normalizedQuery = query.toLowerCase().trim();

        if (normalizedQuery === '') {
            this.filteredTopics = this.topics;
        } else {
            this.filteredTopics = this.topics
                .map(topic => {
                    const matchingQuestions = topic.questions.filter(q => 
                        q.question.toLowerCase().includes(normalizedQuery) ||
                        q.answer.toLowerCase().includes(normalizedQuery)
                    );

                    if (matchingQuestions.length > 0 || 
                        topic.title.toLowerCase().includes(normalizedQuery)) {
                        return {
                            ...topic,
                            questions: matchingQuestions.length > 0 ? matchingQuestions : topic.questions
                        };
                    }
                    return null;
                })
                .filter(topic => topic !== null);
        }

        this.updateTopics();
    }

    updateTopics() {
        const bodyElement = document.getElementById('chatbotBody');
        if (!bodyElement) return;

        bodyElement.innerHTML = this.renderWelcome() + this.renderTopics();

        // Si hay búsqueda activa, expandir el primer resultado
        const searchInput = document.getElementById('chatbotSearch');
        if (searchInput?.value.trim() && this.filteredTopics.length > 0) {
            const firstTopic = document.querySelector('.chatbot-topic');
            firstTopic?.classList.add('expanded');
        }
    }

    openWhatsApp() {
        const message = encodeURIComponent(this.config.whatsappMessage);
        const url = `https://wa.me/${this.config.whatsappNumber}?text=${message}`;
        window.open(url, '_blank');
    }

    /**
     * Destruye el chatbot y limpia recursos
     */
    destroy() {
        if (this.updateTimer) {
            clearInterval(this.updateTimer);
            this.updateTimer = null;
            console.log('Chatbot: Auto-actualización detenida');
        }
    }
}

// Inicializar el chatbot cuando el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initChatbot);
} else {
    initChatbot();
}

function initChatbot() {
    // Detectar entidad actual del localStorage
    const entidad = localStorage.getItem('lastLoginCountry');
    const isStudioBeauty = entidad === 'sb';
    // Determinar la URL del archivo de configuración.
    // Priorizar data-config si el script la declaró; si no, resolverla relativa a la ubicación del propio script.
    const scriptEl = document.currentScript || document.querySelector('script[src*="chatbot.js"]');
    // Valor por defecto relativo al script: 'chatbot-config.json' en el mismo directorio que chatbot.js
    let defaultConfigUrl = null;
    try {
        const scriptSrc = scriptEl && scriptEl.src ? scriptEl.src : window.location.href;
        // Si el script vive en .../js/chatbot.js, esto apuntará a .../js/chatbot-config.json
        defaultConfigUrl = new URL('chatbot-config.json', scriptSrc).href;
    } catch (e) {
        defaultConfigUrl = './js/chatbot-config.json';
    }

    const dataConfig = scriptEl ? scriptEl.getAttribute('data-config') : null;
    const configUrlFromAttr = dataConfig ? new URL(dataConfig, window.location.href).href : null;

    // Configuración base común
    const baseConfig = {
        whatsappNumber: '5491112345678',
        whatsappMessage: '¡Hola! Necesito ayuda con la plataforma.',
        title: isStudioBeauty ? 'Asistente Studio Beauty' : 'Asistente EDDIS',
        subtitle: isStudioBeauty ? 'Tu belleza, nuestra pasión' : 'Estamos aquí para ayudarte',
        configUrl: configUrlFromAttr || defaultConfigUrl
    };

    // Permitir ajustes específicos por entidad si hace falta
    if (isStudioBeauty) {
        baseConfig.whatsappMessage = '¡Hola! Necesito ayuda con Studio Beauty Academy.';
    } else {
        baseConfig.whatsappMessage = '¡Hola! Necesito ayuda con la plataforma EDDIS.';
    }

    window.chatbot = new Chatbot(baseConfig);
}

// Limpiar recursos cuando se cierre la página
window.addEventListener('beforeunload', () => {
    if (window.chatbot) {
        window.chatbot.destroy();
    }
});
