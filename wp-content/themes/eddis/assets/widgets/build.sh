#!/bin/sh

# Limpiar builds anteriores
rm -rf dist/ node_modules/ package-lock.json

# Construir imagen
echo "Construyendo la imagen de Docker..."
docker build -t sedes-widget .

# Ejecutar contenedor con montajes adecuados
echo "Ejecutando el contenedor para compilar..."
docker run --rm -it \
  -v $(pwd)/dist:/app/dist \
  -v $(pwd)/src:/app/src \
  -v $(pwd)/webpack.config.js:/app/webpack.config.js \
  sedes-widget

echo "¡Compilación completada! Archivos disponibles en /dist"
