# Sistema de Chatbot - Documentación

## 📋 Descripción

Sistema de chatbot flotante y configurable para la plataforma EDDIS Alumnos. Incluye:

- ✅ Botón flotante presente en todas las pantallas
- ✅ Temas organizados y expandibles
- ✅ Buscador de preguntas en tiempo real
- ✅ Integración con WhatsApp
- ✅ Diseño responsive
- ✅ Configuración mediante JSON

## 🚀 Archivos Creados

```
eddis/alumnos/
├── css/
│   └── chatbot.css          # Estilos del chatbot
├── js/
│   ├── chatbot.js           # Lógica principal del chatbot
│   └── chatbot-config.json  # Configuración de temas y preguntas
```

## 📦 Instalación

### 1. Incluir archivos CSS y JS

Agregar en el `<head>` de tu HTML:

```html
<!-- Chatbot Styles -->
<link rel="stylesheet" href="../css/chatbot.css">
```

Agregar antes del cierre de `</body>`:

```html
<!-- Chatbot Script -->
<script src="../js/chatbot.js"></script>
```

### 2. Incluir Font Awesome (si no está ya incluido)

```html
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
```

## ⚙️ Configuración

### Configuración Básica en chatbot.js

Puedes personalizar el chatbot editando la función `initChatbot()`:

```javascript
const chatbotConfig = {
    whatsappNumber: '5491112345678',              // Número de WhatsApp (incluir código de país)
    whatsappMessage: '¡Hola! Necesito ayuda...',  // Mensaje predeterminado
    title: 'Asistente EDDIS',                     // Título del chatbot
    subtitle: 'Estamos aquí para ayudarte',       // Subtítulo
    configUrl: './js/chatbot-config.json'         // Ruta al archivo de configuración
};
```

### Configuración de Temas y Preguntas (chatbot-config.json)

El archivo `chatbot-config.json` tiene la siguiente estructura:

```json
{
  "config": {
    "whatsappNumber": "5491112345678",
    "whatsappMessage": "¡Hola! Necesito ayuda...",
    "title": "Asistente EDDIS",
    "subtitle": "Estamos aquí para ayudarte"
  },
  "topics": [
    {
      "id": "inicio",
      "title": "Primeros Pasos",
      "icon": "fa-rocket",
      "questions": [
        {
          "id": "inicio-1",
          "question": "¿Cómo inicio sesión?",
          "answer": "Para iniciar sesión necesitas..."
        }
      ]
    }
  ]
}
```

### Estructura de un Tema

```json
{
  "id": "id-unico",           // ID único del tema
  "title": "Título del Tema", // Título visible
  "icon": "fa-rocket",        // Ícono de Font Awesome
  "questions": [...]          // Array de preguntas
}
```

### Estructura de una Pregunta

```json
{
  "id": "pregunta-1",                    // ID único
  "question": "¿Pregunta frecuente?",    // Texto de la pregunta
  "answer": "Respuesta detallada..."     // Respuesta (soporta HTML)
}
```

## 🎨 Personalización de Estilos

### Variables CSS

Puedes personalizar los colores editando las variables en `chatbot.css`:

```css
:root {
    --chatbot-primary: #32417f;      /* Color principal */
    --chatbot-secondary: #1e3a8a;    /* Color secundario */
    --chatbot-accent: #3b82f6;       /* Color de acento */
    --chatbot-bg: #ffffff;           /* Fondo */
    --chatbot-text: #1f2937;         /* Texto */
    --chatbot-border: #e5e7eb;       /* Bordes */
    --chatbot-shadow: rgba(0, 0, 0, 0.1); /* Sombras */
    --whatsapp-green: #25D366;       /* Verde de WhatsApp */
}
```

### Cambiar Posición del Botón Flotante

Por defecto está en la esquina inferior derecha. Para cambiarlo:

```css
.chatbot-fab {
    bottom: 24px;  /* Distancia desde abajo */
    right: 24px;   /* Distancia desde la derecha */
}
```

## 🔧 API y Métodos

### Instancia Global

El chatbot se instancia globalmente como `window.chatbot`:

```javascript
// Abrir el chatbot
window.chatbot.open();

// Cerrar el chatbot
window.chatbot.close();

// Alternar estado
window.chatbot.toggle();
```

### Configuración Programática

```javascript
// Crear una instancia con configuración personalizada
const miChatbot = new Chatbot({
    whatsappNumber: '5491112345678',
    whatsappMessage: 'Mensaje personalizado',
    title: 'Mi Asistente',
    subtitle: 'Ayuda instantánea',
    configUrl: './config/chatbot.json'
});
```

## 📱 WhatsApp

### Formato del Número

El número debe incluir:
- Código de país (sin +)
- Código de área (sin 0)
- Número local

**Ejemplos:**
- Argentina: `5491112345678` (549 + 11 + número)
- Uruguay: `59812345678` (598 + código + número)
- Paraguay: `595981234567` (595 + código + número)

### Mensaje Predeterminado

Se puede personalizar el mensaje que se envía al hacer clic en el botón de WhatsApp:

```javascript
whatsappMessage: '¡Hola! Necesito ayuda con [tema específico]'
```

## 🎯 Características

### 1. Búsqueda Inteligente

El buscador filtra en tiempo real por:
- Título de temas
- Preguntas
- Respuestas

### 2. Temas Expandibles

- Click en el tema para expandir/contraer
- Solo un tema abierto a la vez
- Animaciones suaves

### 3. Preguntas y Respuestas

- Click en la pregunta para ver la respuesta
- Soporte para HTML en las respuestas
- Múltiples preguntas por tema

### 4. Responsive

- Adaptado para móviles y tablets
- Touch-friendly
- Gestos naturales

### 5. Accesibilidad

- Etiquetas ARIA
- Soporte para teclado (ESC para cerrar)
- Alto contraste
- Focus visible

## 🔄 Actualizar Contenido

### Agregar un Nuevo Tema

1. Editar `chatbot-config.json`
2. Agregar objeto en el array `topics`:

```json
{
  "id": "nuevo-tema",
  "title": "Nuevo Tema",
  "icon": "fa-star",
  "questions": [...]
}
```

3. Los cambios se reflejan automáticamente al recargar

### Agregar Preguntas a un Tema Existente

1. Buscar el tema en `chatbot-config.json`
2. Agregar pregunta en el array `questions`:

```json
{
  "id": "pregunta-nueva",
  "question": "¿Nueva pregunta?",
  "answer": "Respuesta detallada"
}
```

## 🎨 Íconos Disponibles (Font Awesome)

Algunos íconos útiles para temas:

- `fa-rocket` - Inicio/Primeros pasos
- `fa-graduation-cap` - Educación/Cursos
- `fa-clipboard-check` - Tareas/Evaluaciones
- `fa-comments` - Comunicación
- `fa-calendar-alt` - Calendario
- `fa-wrench` - Soporte técnico
- `fa-user-circle` - Perfil
- `fa-certificate` - Certificados
- `fa-phone` - Contacto
- `fa-book` - Biblioteca/Recursos
- `fa-video` - Videos/Multimedia
- `fa-star` - Destacado
- `fa-question-circle` - Ayuda general

Ver más en: https://fontawesome.com/icons

## 🐛 Solución de Problemas

### El chatbot no aparece

1. Verificar que los archivos CSS y JS estén incluidos correctamente
2. Verificar la consola del navegador en busca de errores
3. Asegurarse de que Font Awesome esté cargado

### No se cargan las preguntas

1. Verificar que `chatbot-config.json` esté en la ruta correcta
2. Validar el JSON en https://jsonlint.com
3. Revisar la consola del navegador

### El botón de WhatsApp no funciona

1. Verificar el formato del número de teléfono
2. Asegurarse de que el navegador permita abrir ventanas nuevas
3. Probar el enlace manualmente

### Estilos rotos

1. Verificar que no haya conflictos con otros CSS
2. Asegurarse de que Tailwind CSS (si se usa) no esté sobrescribiendo estilos
3. Aumentar la especificidad si es necesario

## 📝 Ejemplo Completo

```html
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Plataforma</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chatbot CSS -->
    <link rel="stylesheet" href="css/chatbot.css">
</head>
<body>
    
    <!-- Tu contenido aquí -->
    
    <!-- Chatbot JS -->
    <script src="js/chatbot.js"></script>
</body>
</html>
```

## 🔐 Seguridad

- El chatbot no almacena datos sensibles
- Las conversaciones no se guardan
- El número de WhatsApp es público (configúralo adecuadamente)
- Valida siempre el contenido del JSON antes de subirlo

## 📊 Mejoras Futuras Sugeridas

- [ ] Historial de conversaciones
- [ ] Respuestas automáticas con IA
- [ ] Calificación de respuestas
- [ ] Analytics de preguntas más frecuentes
- [ ] Soporte multiidioma
- [ ] Modo oscuro/claro
- [ ] Notificaciones push
- [ ] Chat en vivo con operadores

## 📄 Licencia

Este código es parte del proyecto EDDIS Alumnos.

## 👥 Soporte

Para consultas sobre el chatbot:
- WhatsApp: [Tu número]
- Email: [Tu email]
- Documentación adicional: [URL]

---

**Versión:** 1.0.0  
**Última actualización:** Noviembre 2025
