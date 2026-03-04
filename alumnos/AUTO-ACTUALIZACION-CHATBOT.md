# Sistema de Auto-Actualización del Chatbot

## ✨ Características

El chatbot ahora se actualiza **automáticamente** cuando modificas la configuración desde el panel de administración (`cbotadm`).

### ¿Cómo funciona?

1. **Polling Automático**: Cada 30 segundos, el chatbot verifica si hay cambios en el archivo JSON
2. **Detección de Cambios**: Compara el contenido actual con el nuevo
3. **Actualización Inteligente**: Si detecta cambios, actualiza el contenido automáticamente
4. **Preservación del Estado**: Mantiene el estado de búsqueda y temas expandidos

## 🎯 Beneficios

- ✅ **Sin F5**: Los usuarios no necesitan refrescar la página
- ✅ **Sin Relogin**: Los cambios se ven sin necesidad de volver a iniciar sesión
- ✅ **Tiempo Real**: Actualizaciones en ~30 segundos después de guardar
- ✅ **Experiencia Fluida**: La actualización es transparente para el usuario
- ✅ **Multi-Plataforma**: Funciona en web y móvil

## ⚙️ Configuración

### Cambiar el Intervalo de Actualización

El intervalo por defecto es 30 segundos. Para cambiarlo, edita el archivo `/js/chatbot.js`:

```javascript
// En la inicialización del chatbot
chatbotConfig = {
    // ... otras configuraciones
    autoUpdateInterval: 60000  // 60 segundos (en milisegundos)
};
```

### Valores recomendados:
- **30000** (30 seg) - Recomendado para producción
- **10000** (10 seg) - Para desarrollo/testing rápido
- **60000** (60 seg) - Para reducir carga del servidor

## 📋 Flujo de Actualización

```
1. Admin guarda cambios en cbotadm → save.php actualiza JSON
                                      ↓
2. Chatbot verifica cada 30s → detecta cambios en JSON
                                      ↓
3. Descarga nueva configuración → actualiza contenido
                                      ↓
4. Usuario ve cambios → sin interrupciones
```

## 🔍 Monitoreo

Para ver las actualizaciones en tiempo real, abre la consola del navegador (F12):

```javascript
// Verás mensajes como:
"Chatbot: Auto-actualización activada cada 30 segundos"
"Chatbot: Nueva configuración detectada, actualizando..."
```

## 🛠️ Detalles Técnicos

### Cache Busting
- Agrega `?v=timestamp` a cada petición del JSON
- Headers `Cache-Control: no-cache` y `Pragma: no-cache`
- Garantiza que siempre obtenga la versión más reciente

### Comparación de Cambios
- Usa `JSON.stringify()` para comparar el contenido
- Solo actualiza si hay diferencias reales
- Evita renders innecesarios

### Limpieza de Recursos
- El timer se limpia automáticamente al cerrar la página
- Método `destroy()` para limpieza manual si es necesario

## 📱 Compatibilidad

- ✅ Chrome/Edge (Desktop y Móvil)
- ✅ Firefox (Desktop y Móvil)
- ✅ Safari (Desktop y iOS)
- ✅ Opera
- ✅ Navegadores modernos en general

## ⚡ Optimización

El sistema está optimizado para:
- No consumir recursos excesivos
- Solo actualizar cuando hay cambios reales
- Mantener el chatbot responsive durante la actualización
- Funcionar incluso con conexiones lentas

## 🔧 Troubleshooting

### Los cambios no se reflejan
1. Verifica que el archivo JSON se guardó correctamente
2. Revisa los logs en la consola (F12)
3. Comprueba los permisos del archivo JSON (debe ser writable por www-data)

### Actualización muy lenta
1. Reduce el `autoUpdateInterval` a 10000 (10 segundos) durante desarrollo
2. Verifica la conexión a internet del usuario

### Errores en consola
- Revisa que el archivo JSON tenga formato válido
- Verifica que la ruta del `configUrl` sea correcta
- Comprueba permisos del servidor

## 📝 Notas

- El sistema solo actualiza cuando el chatbot está **visible** (abierto)
- Si el chatbot está cerrado, se actualizará cuando el usuario lo abra
- La primera carga siempre obtiene la configuración más reciente
- No afecta el rendimiento de la página cuando está inactivo
