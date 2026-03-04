# 🤖 Sistema de Chatbot - Inicio Rápido

## ✅ Instalación Completada

El sistema de chatbot ya está instalado en tu proyecto **eddis/alumnos**.

## 📁 Archivos Creados

```
eddis/alumnos/
├── css/
│   └── chatbot.css                      # Estilos del chatbot
├── js/
│   ├── chatbot.js                       # Lógica principal
│   ├── chatbot-config.json              # Configuración EDDIS
│   └── chatbot-config-studio.json       # Configuración Studio Beauty
├── components/
│   └── chatbot-component.html           # Componente reutilizable
├── pages/
│   └── chatbot-demo.html                # Página de demostración
├── install-chatbot.sh                   # Script de instalación
├── CHATBOT-README.md                    # Documentación completa
└── INICIO-RAPIDO.md                     # Este archivo
```

## 🚀 Uso Inmediato

### Ver la Demo
Abre en tu navegador:
```
pages/chatbot-demo.html
```

### Probar en Páginas Existentes
El chatbot ya está integrado en:
- ✅ `pages/inicio.html`
- ✅ `pages/dash.html`

## ⚙️ Configuración Rápida

### 1. Actualizar Número de WhatsApp

Edita `js/chatbot.js` y busca:
```javascript
whatsappNumber: '5491112345678'
```

Reemplaza con tu número (incluir código de país sin +)

### 2. Personalizar Preguntas

Edita los archivos de configuración:
- **EDDIS:** `js/chatbot-config.json`
- **Studio Beauty:** `js/chatbot-config-studio.json`

### 3. Cambiar Colores

Edita `css/chatbot.css` y modifica las variables:
```css
:root {
    --chatbot-primary: #32417f;    /* Tu color principal */
    --chatbot-secondary: #1e3a8a;  /* Tu color secundario */
}
```

## 🎨 Características Principales

- ✅ **Botón flotante** en todas las pantallas
- ✅ **Temas expandibles** organizados por categorías
- ✅ **Búsqueda en tiempo real** de preguntas
- ✅ **Integración con WhatsApp** con un clic
- ✅ **100% Responsive** para móviles y tablets
- ✅ **Detección automática** de entidad (EDDIS/Studio Beauty)
- ✅ **Totalmente configurable** mediante JSON

## 📱 Cómo Funciona

1. **Haz clic** en el botón flotante (esquina inferior derecha)
2. **Busca** tu pregunta o explora los temas
3. **Expande** los temas haciendo clic en ellos
4. **Lee** las respuestas clickeando en las preguntas
5. **Contacta** por WhatsApp si necesitas más ayuda

## 🔧 Agregar a Más Páginas

### Método Manual
Agrega en el `<head>`:
```html
<link rel="stylesheet" href="../css/chatbot.css">
```

Agrega antes del `</body>`:
```html
<script src="../js/chatbot.js"></script>
```

### Método Automático
Ejecuta el script de instalación:
```bash
bash install-chatbot.sh
```

## 📝 Agregar Nuevas Preguntas

Edita `js/chatbot-config.json` y agrega en el array de `questions`:

```json
{
  "id": "nueva-pregunta",
  "question": "¿Tu pregunta aquí?",
  "answer": "Tu respuesta detallada aquí"
}
```

## 📖 Documentación Completa

Para más detalles, consulta: **CHATBOT-README.md**

## 🎯 Próximos Pasos

1. ✅ Actualiza el número de WhatsApp
2. ✅ Personaliza las preguntas frecuentes
3. ✅ Ajusta los colores (opcional)
4. ✅ Prueba en `chatbot-demo.html`
5. ✅ Agrega a todas tus páginas

## 💡 Tips

- El chatbot detecta automáticamente si es EDDIS o Studio Beauty
- Los temas se pueden expandir/contraer clickeando
- El buscador filtra en tiempo real
- Se puede cerrar con ESC o clickeando fuera

## 🆘 Soporte

¿Problemas? Revisa:
1. Consola del navegador (F12)
2. Que los archivos CSS y JS estén cargados
3. Que Font Awesome esté disponible
4. La documentación completa en CHATBOT-README.md

---

**¡Listo para usar! 🎉**
