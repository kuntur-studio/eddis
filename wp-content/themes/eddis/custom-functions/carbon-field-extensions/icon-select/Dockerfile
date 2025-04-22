# Usa una imagen base con NodeJS 22.14.0
FROM node:22.14.0

# Establece el directorio de trabajo
WORKDIR /app

# Configura Node.js para usar un algoritmo de hash compatible
ENV NODE_OPTIONS="--openssl-legacy-provider"

# Copia el package.json y yarn.lock
COPY package.json yarn.lock ./

# Instala las dependencias con las versiones más recientes de Babel
RUN yarn add --dev \
    @babel/core@latest \
    @babel/preset-env@latest \
    @babel/preset-react@latest \
    @babel/plugin-proposal-class-properties@latest \
    @babel/plugin-proposal-object-rest-spread@latest \
    @babel/plugin-syntax-async-generators@latest \
    @babel/plugin-transform-runtime@latest

# Copia el resto del proyecto
COPY . .

