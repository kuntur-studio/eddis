#!/bin/bash

# 1. Construir imagen (solo preparación)
echo "🛠️ Construyendo imagen Docker con el entorno..."
docker build -t branches-widget-env . || {
  echo "❌ Error al construir la imagen Docker";
  exit 1;
}

# 2. Asegurar que existe el directorio dist
mkdir -p dist

# 3. Ejecutar compilación montando volúmenes necesarios
echo "🔨 Compilando el proyecto..."
docker run --rm \
  -v $(pwd)/src:/app/src \
  -v $(pwd)/dist:/app/dist \
  -v $(pwd)/webpack.config.js:/app/webpack.config.js \
  branches-widget-env || {
  echo "❌ Error durante la compilación";
  exit 1;
}

# 4. Resultado final
echo "✅ ¡Compilación completada con éxito!"
echo "📁 Archivos generados en: $(pwd)/dist"
ls -lh dist/
