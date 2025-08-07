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

`sudo -u eddisar wp plugin update --all`

Este método asegura que las actualizaciones se apliquen de forma segura y controlada, evitando posibles problemas de permisos o corrupción de archivos.