# 📋 Documentación: Gestión de Formularios de Marketing

---

## 🚀 Visión General de la Funcionalidad

La gestión de los formularios de marketing se realiza a través de un **Custom Post Type (CPT)** llamado "Formularios de Marketing". Esta funcionalidad se creó para centralizar la gestión del código de los formularios (HTML, CSS, JavaScript) y facilitar la integración con diferentes plataformas de marketing y CRM, permitiendo cambiar de proveedor sin modificar las plantillas del sitio.

Cada formulario es una entrada de este CPT y sus propiedades se definen mediante **campos personalizados** de **Carbon Fields**.

---

## 🛠️ Uso y Configuración

Para gestionar los formularios, navega a la sección **"Formularios de Marketing"** en el panel de administración de WordPress.

### **Crear un nuevo formulario**

1.  Haz clic en **"Añadir nuevo"**.
2.  Asigna un **nombre** descriptivo al formulario. Este nombre es crucial, ya que se utilizará para referenciarlo en el código de las plantillas.

### **Campos disponibles**

Al editar un formulario, encontrarás los siguientes campos:

* **Nombre del Formulario:** Un identificador único, en formato de texto corto, sin espacios y en minúsculas (ej. `newsletter_form`). Este es el valor que usarás en el código.
* **Estado:** Un selector que permite **activar** o **desactivar** el formulario. Los formularios desactivados no se renderizarán en el sitio web.
* **Código del Formulario:** Un área de texto donde debes pegar el código completo (HTML, CSS y JS) que te proporcione tu plataforma de CRM o marketing.

### **Inserción en las plantillas**

Para mostrar un formulario en cualquier plantilla de WordPress, utiliza la función edd_get_eddis_form_data para obtener un array con los datos del formulario:

```php
<?php 
// El "Nombre de Identificación" que se definio en el gestor de formularios
$form_name = 'form-home';
$form      = edd_get_eddis_form_data($form_name);

// $form es un array asociativo que contiene los elementos "active" y "code"
 ?>
```

Asegúrate de reemplazar `'nombre_del_formulario'` con el nombre exacto que asignaste en el campo **"Nombre del Formulario"** dentro del panel de administración.

---

## 💡 Ventajas Clave

* **Facilidad de mantenimiento:** Si necesitas cambiar de proveedor de CRM (por ejemplo, de Mailchimp a HubSpot), solo debes actualizar el código del formulario en el CPT. No es necesario modificar los archivos de las plantillas.
* **Gestión centralizada:** Todos los formularios están en un único lugar, lo que simplifica su administración y control.
* **Separación de lógica y diseño:** Separamos el código del formulario del diseño de la plantilla, lo que hace el proyecto más robusto y fácil de escalar.