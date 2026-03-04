/**
 * EJEMPLOS DE PERSONALIZACIÓN DEL CHATBOT
 * ========================================
 * 
 * Este archivo contiene ejemplos de cómo personalizar el chatbot
 * para diferentes necesidades y casos de uso.
 */

// =============================================================================
// EJEMPLO 1: Configuración Básica Personalizada
// =============================================================================

const configBasica = {
    whatsappNumber: '5491112345678',
    whatsappMessage: '¡Hola! Necesito ayuda con la plataforma.',
    title: 'Mi Asistente',
    subtitle: 'Estamos para ayudarte',
    configUrl: './js/chatbot-config.json'
};

// new Chatbot(configBasica);


// =============================================================================
// EJEMPLO 2: Diferentes Configuraciones por Página
// =============================================================================

// En página de cursos
const configCursos = {
    whatsappNumber: '5491112345678',
    whatsappMessage: 'Hola, tengo una consulta sobre mis cursos',
    title: 'Ayuda - Mis Cursos',
    subtitle: 'Consultas sobre cursos',
    configUrl: './js/chatbot-config-cursos.json'
};

// En página de pagos
const configPagos = {
    whatsappNumber: '5491112345678',
    whatsappMessage: 'Hola, necesito ayuda con un pago',
    title: 'Ayuda - Pagos',
    subtitle: 'Consultas sobre pagos',
    configUrl: './js/chatbot-config-pagos.json'
};


// =============================================================================
// EJEMPLO 3: Cambiar Configuración Dinámicamente
// =============================================================================

function cambiarConfiguracion() {
    // Destruir chatbot actual
    if (window.chatbot) {
        const fab = document.getElementById('chatbotFab');
        const container = document.getElementById('chatbotContainer');
        fab?.remove();
        container?.remove();
    }
    
    // Crear nuevo chatbot con otra configuración
    window.chatbot = new Chatbot({
        whatsappNumber: '5491198765432',
        title: 'Nueva Configuración',
        subtitle: 'Configuración cambiada dinámicamente'
    });
}


// =============================================================================
// EJEMPLO 4: Abrir el Chatbot Automáticamente
// =============================================================================

// Abrir después de 5 segundos
setTimeout(() => {
    window.chatbot?.open();
}, 5000);

// Abrir cuando el usuario hace scroll
let scrolled = false;
window.addEventListener('scroll', () => {
    if (!scrolled && window.scrollY > 500) {
        scrolled = true;
        window.chatbot?.open();
    }
});

// Abrir al hacer clic en un botón específico
document.getElementById('miBotonAyuda')?.addEventListener('click', () => {
    window.chatbot?.open();
});


// =============================================================================
// EJEMPLO 5: Tracking de Eventos
// =============================================================================

// Monitorear cuando se abre el chatbot
document.addEventListener('DOMContentLoaded', () => {
    const fab = document.getElementById('chatbotFab');
    fab?.addEventListener('click', () => {
        console.log('Chatbot abierto');
        // Aquí puedes enviar a Google Analytics, Mixpanel, etc.
        // gtag('event', 'chatbot_opened');
    });
});

// Monitorear qué preguntas se expanden
document.addEventListener('click', (e) => {
    const question = e.target.closest('.chatbot-question');
    if (question) {
        const questionText = question.querySelector('.chatbot-question-title span')?.textContent;
        console.log('Pregunta expandida:', questionText);
        // gtag('event', 'question_viewed', { question: questionText });
    }
});

// Monitorear clics en WhatsApp
document.addEventListener('DOMContentLoaded', () => {
    const whatsappBtn = document.getElementById('chatbotWhatsapp');
    whatsappBtn?.addEventListener('click', () => {
        console.log('WhatsApp clickeado');
        // gtag('event', 'whatsapp_clicked');
    });
});


// =============================================================================
// EJEMPLO 6: Mostrar Notificación en el Botón
// =============================================================================

function mostrarNotificacion() {
    const fab = document.getElementById('chatbotFab');
    
    // Crear badge si no existe
    let badge = fab?.querySelector('.chatbot-badge');
    if (!badge) {
        badge = document.createElement('div');
        badge.className = 'chatbot-badge';
        fab?.appendChild(badge);
    }
    
    // Actualizar número
    badge.textContent = '1';
    
    // Quitar al abrir el chatbot
    fab?.addEventListener('click', () => {
        badge?.remove();
    }, { once: true });
}

// Mostrar notificación después de 10 segundos
setTimeout(mostrarNotificacion, 10000);


// =============================================================================
// EJEMPLO 7: Búsqueda Programática
// =============================================================================

function buscarEnChatbot(query) {
    // Abrir chatbot
    window.chatbot?.open();
    
    // Esperar a que esté abierto
    setTimeout(() => {
        const searchInput = document.getElementById('chatbotSearch');
        if (searchInput) {
            searchInput.value = query;
            searchInput.dispatchEvent(new Event('input'));
        }
    }, 300);
}

// Usar desde cualquier parte de tu código
// buscarEnChatbot('calificaciones');


// =============================================================================
// EJEMPLO 8: Configuración Según Rol de Usuario
// =============================================================================

function inicializarChatbotPorRol() {
    const userRole = localStorage.getItem('userRole'); // 'student', 'teacher', 'admin'
    
    let config = {};
    
    switch (userRole) {
        case 'student':
            config = {
                title: 'Ayuda para Estudiantes',
                configUrl: './js/chatbot-config-students.json',
                whatsappMessage: 'Hola, soy estudiante y necesito ayuda'
            };
            break;
            
        case 'teacher':
            config = {
                title: 'Ayuda para Profesores',
                configUrl: './js/chatbot-config-teachers.json',
                whatsappMessage: 'Hola, soy profesor y necesito ayuda'
            };
            break;
            
        case 'admin':
            config = {
                title: 'Ayuda para Administradores',
                configUrl: './js/chatbot-config-admin.json',
                whatsappMessage: 'Hola, soy administrador y necesito ayuda'
            };
            break;
            
        default:
            config = {
                title: 'Asistente Virtual',
                configUrl: './js/chatbot-config.json'
            };
    }
    
    window.chatbot = new Chatbot(config);
}


// =============================================================================
// EJEMPLO 9: Integración con Sistema de Tickets
// =============================================================================

function crearTicketDesdeChat() {
    const chatbotFooter = document.querySelector('.chatbot-footer');
    
    // Agregar botón para crear ticket
    const ticketBtn = document.createElement('button');
    ticketBtn.className = 'chatbot-whatsapp-btn';
    ticketBtn.style.background = '#ef4444';
    ticketBtn.style.marginTop = '8px';
    ticketBtn.innerHTML = `
        <i class="fas fa-ticket-alt"></i>
        <span>Crear Ticket de Soporte</span>
    `;
    
    ticketBtn.addEventListener('click', () => {
        // Lógica para crear ticket
        console.log('Crear ticket de soporte');
        // window.location.href = '/crear-ticket';
    });
    
    chatbotFooter?.appendChild(ticketBtn);
}

// Ejecutar cuando el DOM esté listo
// document.addEventListener('DOMContentLoaded', crearTicketDesdeChat);


// =============================================================================
// EJEMPLO 10: Chatbot con Horario de Atención
// =============================================================================

function verificarHorarioAtencion() {
    const now = new Date();
    const hour = now.getHours();
    const day = now.getDay(); // 0 = Domingo, 6 = Sábado
    
    // Horario: Lunes a Viernes 9-18hs
    const esDiaHabil = day >= 1 && day <= 5;
    const esHorarioAtencion = hour >= 9 && hour < 18;
    
    if (!esDiaHabil || !esHorarioAtencion) {
        // Modificar el mensaje de WhatsApp
        const whatsappBtn = document.getElementById('chatbotWhatsapp');
        if (whatsappBtn) {
            whatsappBtn.innerHTML = `
                <i class="fab fa-whatsapp"></i>
                <span>WhatsApp (Fuera de horario)</span>
            `;
        }
        
        // Agregar mensaje en el footer
        const footer = document.querySelector('.chatbot-footer');
        const mensaje = document.createElement('p');
        mensaje.style.fontSize = '12px';
        mensaje.style.color = '#6b7280';
        mensaje.style.marginTop = '8px';
        mensaje.textContent = 'Horario de atención: Lun-Vie 9-18hs';
        footer?.insertBefore(mensaje, footer.firstChild);
    }
}


// =============================================================================
// EJEMPLO 11: Sugerencias Inteligentes
// =============================================================================

function agregarSugerencias() {
    const commonQueries = [
        'inicio de sesión',
        'calificaciones',
        'materiales',
        'horarios'
    ];
    
    const welcomeDiv = document.querySelector('.chatbot-welcome');
    
    const suggestionsHTML = `
        <div style="margin-top: 20px;">
            <p style="font-size: 13px; color: #6b7280; margin-bottom: 10px;">Búsquedas populares:</p>
            <div style="display: flex; flex-wrap: wrap; gap: 8px; justify-content: center;">
                ${commonQueries.map(query => `
                    <button class="suggestion-chip" style="
                        padding: 6px 12px;
                        background: #f3f4f6;
                        border: 1px solid #e5e7eb;
                        border-radius: 16px;
                        font-size: 12px;
                        cursor: pointer;
                        transition: all 0.2s;
                    " onclick="buscarEnChatbot('${query}')">
                        ${query}
                    </button>
                `).join('')}
            </div>
        </div>
    `;
    
    welcomeDiv?.insertAdjacentHTML('beforeend', suggestionsHTML);
}


// =============================================================================
// EJEMPLO 12: Tema Oscuro/Claro
// =============================================================================

function aplicarTemaOscuro() {
    const style = document.createElement('style');
    style.textContent = `
        .chatbot-container {
            background: #1f2937 !important;
        }
        .chatbot-body {
            background: #1f2937 !important;
        }
        .chatbot-topic {
            background: #374151 !important;
            border-color: #4b5563 !important;
        }
        .chatbot-topic-title span,
        .chatbot-question-title,
        .chatbot-answer-content {
            color: #f3f4f6 !important;
        }
        .chatbot-search-input {
            background: #374151 !important;
            color: #f3f4f6 !important;
            border-color: #4b5563 !important;
        }
    `;
    document.head.appendChild(style);
}

// Aplicar según preferencia del usuario
if (localStorage.getItem('darkMode') === 'true') {
    // aplicarTemaOscuro();
}


// =============================================================================
// USO DE LOS EJEMPLOS
// =============================================================================

/*
Para usar cualquiera de estos ejemplos:

1. Copia el código que necesites
2. Pégalo en tu archivo JavaScript principal
3. Llama a la función donde corresponda
4. Personaliza según tus necesidades

Ejemplo:
document.addEventListener('DOMContentLoaded', () => {
    verificarHorarioAtencion();
    agregarSugerencias();
});
*/
