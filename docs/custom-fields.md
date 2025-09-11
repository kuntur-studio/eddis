# ✍️ Documentación: Uso de Campos Personalizados con Carbon Fields

---

## 🚀 Visión General

Este documento describe la implementación de campos personalizados en el sitio web, utilizando la librería **Carbon Fields**. Esta herramienta nos permite añadir campos personalizados a diferentes tipos de contenido de WordPress para gestionar datos adicionales de forma estructurada, facilitando la creación de contenido dinámico.

---

## 🛠️ Implementaciones

Carbon Fields se ha utilizado para extender la funcionalidad de las siguientes secciones del sitio. Toda la definición de los campos se encuentra en el archivo: [custom-fields.php](/wp-content/themes/eddis/custom-functions/custom-fields.php).

### **Productos y Categorías de WooCommerce**

Se han añadido campos personalizados para gestionar atributos específicos del catálogo, como **datos adicionales del producto**, **color de las categorías**, etc.

### **Custom Post Types (CPT)**

Se han agregado campos a los siguientes Custom Post Types para gestionar sus datos de forma estructurada:

* **Formularios de Marketing**: Permite gestionar el código de inserción (HTML, CSS y JS) de los formularios, así como su nombre y estado de activación.
* **Sedes**: Para gestionar la información de las diferentes ubicaciones, como dirección, teléfono, etc.

### **Panel de Opciones del Tema**

Se ha creado un panel de configuración general del tema utilizando Carbon Fields. Este panel centraliza ajustes globales del sitio, permitiendo a los administradores gestionar:

* Ítems del **menú de navegación** principal y del _footer_.
* **Redes sociales**.
* **Datos de contacto** (teléfono, correo electrónico, etc.).
* El **Service Tag de GTM** (Google Tag Manager).
* La carga de **assets** (archivos estáticos).
* La gestión de **widgets personalizados**.

---

## 💡 Ventajas Clave

* **Optimización vs. ACF**: La implementación con Carbon Fields evita la generación de código basura y ofrece un control total sobre el código. Esto se traduce en un **mejor rendimiento y un uso más eficiente de los recursos**, haciendo el sitio más rápido y ligero en comparación con otras soluciones.

* **Interfaz de Usuario Amigable**: La gestión de los campos se realiza desde una interfaz de usuario intuitiva dentro del panel de administración de WordPress, facilitando su uso a cualquier persona.