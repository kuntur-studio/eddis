#!/bin/bash

# Parámetro para forzar la reconstrucción de la imagen
FORCE_REBUILD=${1:-false}

# Verifica si la imagen ya está construida
if [[ "$FORCE_REBUILD" == "true" || "$(docker images -q docker-image 2> /dev/null)" == "" ]]; then
  echo "Construyendo la imagen Docker..."
  docker build -t docker-image .
else
  echo "La imagen Docker ya está construida."
fi

# Ejecuta el contenedor para generar los assets
echo "Generando los assets..."
docker run --rm \
  -v $(pwd)/src:/app/src \
  -v $(pwd)/build:/app/build \
  -v $(pwd)/languages:/app/languages \
  docker-image yarn build
