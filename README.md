# Consideraciones de desarrollo para Eddis Educativa

Este documento establece las directrices y consideraciones clave para el desarrollo y mantenimiento del sitio web de Eddis Educativa. Es fundamental seguir estas pautas para asegurar la estabilidad, seguridad y coherencia del proyecto.

---

### Actualización del Core de WordPress

Para actualizar el core de WordPress, es imperativo utilizar la terminal vía SSH, en lugar del panel de administración. Esto garantiza que el proceso se realice de forma controlada y segura, manteniendo la consistencia del sitio. El comando de WP-CLI para realizar esta operación es el siguiente:

```bash
sudo -u eddisar wp core update
```

---

## Mantenimiento de plugins

Para actualizar los plugins del sitio web, se debe utilizar la terminal a través de una conexión SSH. Es crucial no realizar estas actualizaciones desde el panel de administración de WordPress. El método preferido es usar **WP-CLI**, impersonando al usuario **apache** para garantizar los permisos correctos. Un ejemplo del comando para actualizar todos los plugins es el siguiente:

```bash
sudo -u eddisar wp plugin update --all
```

Este método asegura que las actualizaciones se apliquen de forma segura y controlada, evitando posibles problemas de permisos o corrupción de archivos.


## Desarrollo y Gestión del Widget de Sedes

Para el desarrollo del widget de sedes se utilizó la librería `@wordpress/components`, que proporciona una personalización de React optimizada para el ecosistema de WordPress.

El proceso de build del widget se automatizó a través de un shell script llamado `build.sh`, ubicado en la ruta:

```bash
wp-content/themes/eddis/assets/widgets/branches-widget/
```

Este script es el encargado de instanciar un contenedor Docker para realizar el proceso de compilación, lo que elimina la necesidad de instalar dependencias de desarrollo en el sistema operativo del servidor.

Esta estrategia fue crucial, ya que el servidor cloud de desarrollo y producción utilizaba una versión antigua de CentOS que no era compatible con las librerías de build necesarias.

La inclusión del widget en el sitio se gestiona desde el panel admin de WordPress en la sección de **Configuración General** del sitio, y las páginas donde debe mostrarse el componente contienen un contenedor con el ID `branches-widget-root`, el cual se inserta en las plantillas del tema mediante el fragmento de código:

```php
<?php get_template_part('template-parts/sedes'); ?>
```

El código responsable de encolar los assets en las páginas seleccionadas desde el panel de Configuración General se encuentra en el archivo:

```bash
wp-content/themes/eddis/custom-functions/assets.php
```

Este archivo también se encarga de incrustar un script adicional en la página que contiene un objeto JSON con los datos de sedes requeridos por el widget, utilizando `wp_localize_script`.

### Actualización del Widget de Sedes

Para facilitar la actualización del widget, se creó un script en el directorio /home/eddisar/ llamado pull-git-and-build-branches-widget.sh y el comando:

```bash
updbranches
```

definido como alias en el .bashrc del usuario root que permite ejecutar el script fácilmente desde cualquier ubicación.
Al ejecutar el comando y correr el script, se establece el directorio actual al directorio raíz del proyecto y luego ejecuta el comando git pull, que obtiene todos lis cambios desde el repositorio remoto en github (requiere el usuario/email y token de autenticación).

**Cuidado**, al obtener los cambios desde el repositorio remoto se obtienen  para todo el proyecto, no solo los que aplican al widget.

Finalmente, se posiciona en el directorio contenedor de los archivos del widget y ejecuta el script build.sh para reconstruirlo incorporando los últimos cambios.