FROM node:20-alpine

WORKDIR /app

# 1. Copiar archivos de configuración y dependencias
COPY package*.json ./
COPY webpack.config.js ./

# 2. Instalar dependencias (producción + solo las dev necesarias para build)
RUN npm ci --only=production && \
    npm install --no-save webpack webpack-cli babel-loader @babel/core @babel/preset-env @babel/preset-react sass-loader sass && \
    npm cache clean --force

# 3. Copiar código fuente y crear directorios
COPY src ./src
RUN mkdir -p dist

# 4. Punto de entrada para compilación
CMD ["npm", "run", "build"]
