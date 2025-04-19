FROM node:18-alpine

WORKDIR /app

# Instalar dependencias del sistema y limpiar cache
RUN apk add --no-cache jq

# Copiar solo los archivos necesarios para instalar dependencias primero
COPY package*.json ./
COPY webpack.config.js ./

# Generar package.json si no existe con configuraciones específicas
RUN if [ ! -f package.json ]; then \
      npm init -y && \
      jq '.scripts += { "build": "webpack --mode production", "dev": "webpack --watch --mode development" }' package.json > temp.json && \
      jq '.dependencies += { "@wordpress/element": "^4.0.0" }' temp.json > temp2.json && \
      jq '.devDependencies += { "webpack": "^5.89.0", "webpack-cli": "^5.1.4", "babel-loader": "^9.1.3", "@babel/core": "^7.23.0", "@babel/preset-env": "^7.23.0", "@babel/preset-react": "^7.22.15" }' temp2.json > package.json && \
      rm temp.json temp2.json; \
    fi

# Instalar dependencias exactas
RUN npm ci

# Copiar el resto de los archivos
COPY . .

# Compilar el proyecto
RUN npm run build

# Comando por defecto
CMD ["npm", "run", "dev"]
