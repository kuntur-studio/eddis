#!/bin/bash

# Elimino node_modules y package-lock.json y lo regenero
rm -rf node_modules package-lock.json

# Monta el directorio actual en /app y ejecuta npm install con Node.js 18
docker run --rm -v "$PWD":/app -w /app node:18 npm install
