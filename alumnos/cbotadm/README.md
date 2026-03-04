# Panel de Administración del Chatbot

## 📋 Descripción

Panel CRUD para administrar las preguntas y respuestas del chatbot de EDDIS y Studio Beauty.

## 🚀 Acceso

```
http://localhost/eddis/alumnos/cbotadm/
```

O desde el dashboard:
```
http://localhost/eddis/alumnos/?page=dash
```
(Agregar enlace al menú)

## ✨ Características

### ✅ Gestión de Configuración General
- Número de WhatsApp
- Mensaje predeterminado de WhatsApp
- Título del chatbot
- Subtítulo del chatbot

### ✅ Gestión de Temas
- Crear nuevos temas
- Editar temas existentes
- Eliminar temas
- Configurar ícono de Font Awesome
- Ver cantidad de preguntas por tema

### ✅ Gestión de Preguntas
- Agregar preguntas a cualquier tema
- Editar preguntas existentes
- Eliminar preguntas
- Respuestas con soporte HTML

### ✅ Seguridad
- Backups automáticos antes de guardar
- Se mantienen los últimos 5 backups
- Validación de datos
- Sistema de respaldo

## 📁 Estructura de Archivos

```
cbotadm/
├── index.html          # Interfaz principal
├── css/
│   └── admin.css       # Estilos del panel
├── js/
│   └── admin.js        # Lógica del CRUD
└── api/
    └── save.php        # API para guardar cambios
```

## 🎯 Uso

### 1. Seleccionar Entidad
Elige entre EDDIS o Studio Beauty en el selector superior.

### 2. Configurar Datos Generales
- Edita el número de WhatsApp
- Personaliza los mensajes
- Haz clic en "Guardar Configuración"

### 3. Gestionar Temas

#### Crear Tema:
1. Clic en "Nuevo Tema"
2. Completar:
   - **ID**: identificador único (ej: `soporte-tecnico`)
   - **Título**: nombre visible (ej: `Soporte Técnico`)
   - **Ícono**: ícono de Font Awesome (ej: `fa-wrench`)
3. Guardar

#### Editar Tema:
1. Clic en el ícono de edición del tema
2. Modificar datos
3. Guardar

#### Eliminar Tema:
1. Clic en el ícono de eliminar
2. Confirmar acción

### 4. Gestionar Preguntas

#### Agregar Pregunta:
1. Expandir un tema (clic en la cabecera)
2. Clic en "Nueva Pregunta"
3. Completar:
   - **ID**: identificador único (ej: `pregunta-1`)
   - **Pregunta**: texto de la pregunta
   - **Respuesta**: texto de la respuesta (puede usar HTML)
4. Guardar

#### Editar Pregunta:
1. Clic en el ícono de edición de la pregunta
2. Modificar datos
3. Guardar

#### Eliminar Pregunta:
1. Clic en el ícono de eliminar
2. Confirmar acción

## 🎨 Íconos Font Awesome

Buscar íconos en: https://fontawesome.com/icons

Ejemplos comunes:
- `fa-rocket` - Inicio
- `fa-graduation-cap` - Educación
- `fa-wrench` - Soporte
- `fa-phone` - Contacto
- `fa-calendar` - Calendario
- `fa-user` - Usuario
- `fa-book` - Materiales
- `fa-star` - Destacado
- `fa-spa` - Belleza
- `fa-palette` - Arte/Diseño

## 💾 Sistema de Backups

Cada vez que guardes cambios, se crea automáticamente un backup con formato:
```
chatbot-config.json.backup.2025-11-14_15-30-45
```

Los backups se guardan en:
```
../js/chatbot-config.json.backup.*
../js/chatbot-config-studio.json.backup.*
```

**Se mantienen los últimos 5 backups automáticamente.**

### Restaurar un Backup

Si necesitas restaurar una versión anterior:

1. Ve al directorio `js/`
2. Busca el backup que quieres restaurar
3. Renombra el backup eliminando `.backup.fecha`:
   ```bash
   mv chatbot-config.json.backup.2025-11-14_15-30-45 chatbot-config.json
   ```

## 🔒 Validaciones

### ID de Tema/Pregunta:
- Solo letras minúsculas
- Solo números
- Solo guiones (-)
- Sin espacios ni caracteres especiales

Ejemplos válidos:
- ✅ `soporte-tecnico`
- ✅ `pregunta-1`
- ✅ `inicio-sesion`
- ❌ `Soporte Técnico` (mayúsculas y espacios)
- ❌ `pregunta_1` (guión bajo)

### Campos Requeridos:
- Todos los campos marcados con (*) son obligatorios
- No se puede guardar con campos vacíos

## 📱 Responsive

El panel es totalmente responsive y funciona en:
- ✅ Desktop
- ✅ Tablet
- ✅ Móvil

## ⚡ Atajos de Teclado

- **ESC**: Cerrar modal
- **Enter**: Guardar (cuando un input tiene foco)

## 🔄 Flujo de Trabajo Recomendado

1. Crear estructura de temas primero
2. Agregar preguntas a cada tema
3. Revisar y editar según necesidad
4. Probar en el chatbot real
5. Ajustar respuestas según feedback

## 🛠️ Mantenimiento

### Ver Backups Creados
```bash
ls -la /ruta/a/alumnos/js/*.backup.*
```

### Limpiar Backups Manualmente
```bash
rm /ruta/a/alumnos/js/*.backup.*
```

## ⚠️ Importante

1. **Siempre prueba los cambios** en el chatbot después de guardar
2. **Los backups se crean automáticamente**, pero puedes hacer copias manuales adicionales
3. **Valida el JSON** si editas manualmente los archivos
4. **No uses comillas especiales** (" ") en las respuestas, usa comillas simples (")

## 🐛 Solución de Problemas

### No se guardan los cambios
- Verifica permisos del directorio `js/`
- Revisa la consola del navegador (F12)
- Comprueba que el servidor PHP esté funcionando

### Error al cargar configuración
- Verifica que los archivos JSON existan
- Valida el JSON en https://jsonlint.com
- Revisa permisos de lectura

### Backups no se crean
- Verifica permisos de escritura en `js/`
- Comprueba espacio en disco
- Revisa logs del servidor

## 📞 Soporte

Para problemas con el panel de administración:
1. Revisa los backups automáticos
2. Consulta la consola del navegador
3. Verifica permisos de archivos
4. Contacta con soporte técnico

---

**Versión:** 1.0.0  
**Última actualización:** Noviembre 2025
