# 🗺️ Documentación: Widget de Sedes

---

## 🚀 Visión General

El Widget de Sedes es un componente interactivo que permite a los usuarios explorar las diferentes sucursales organizadas por provincias y ciudades. Está diseñado para ser cargado en páginas clave del sitio para facilitar la localización de sucursales.

El componente está desarrollado con la librería `@wordpress/element`, una capa ligera y personalizada de React, lo que permite una interfaz dinámica y reactiva.

---

## 🛠️ Carga y Gestión del Widget

El widget se carga en el _frontend_ en las siguientes páginas: **Inicio**, **Sedes** y **Contacto**. La gestión de la visibilidad del widget es centralizada y se realiza desde el **Panel de Opciones del Tema**, bajo la pestaña **Widgets/Sedes**. Desde allí, se puede activar o desactivar el widget de forma general o por página.

El código encargado de insertar el widget y sus datos en el _frontend_ se encuentra en el archivo: [assets.php](/wp-content/themes/eddis/custom-functions/assets.php).

### **Localización de Datos**

Cuando el widget se inserta, también se insertan los datos de las sucursales. Esto se logra a través de la función `edd_localize_branches_data()`, que obtiene todos los datos de las taxonomías de ciudades y provincias, junto con sus sedes correspondientes. Estos datos se hacen disponibles en el _frontend_ como un objeto JSON, gracias a la función `wp_localize_script()`.

---

## ⚙️ Proceso de _Build_

El proceso de compilación del widget se gestiona a través de un _shell script_ llamado `build.sh`. Este script utiliza un **contenedor Docker** para el proceso de _build_.

Este método de desarrollo se implementó debido a que el servidor actual utiliza una versión antigua del sistema operativo, lo que impedía la actualización de las dependencias de compilación. El uso de Docker como **capa de abstracción** permite asegurar que el proceso de compilación se ejecute en un entorno moderno y controlado, garantizando la compatibilidad y el correcto funcionamiento del _build_ sin depender de las versiones de software del servidor.