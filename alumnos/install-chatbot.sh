#!/bin/bash

# =============================================================================
# SCRIPT DE INSTALACIÓN DEL CHATBOT - EDDIS ALUMNOS
# =============================================================================
# Este script agrega automáticamente el chatbot a todas las páginas HTML
# del proyecto eddis/alumnos
#
# Uso: bash install-chatbot.sh
# =============================================================================

# Colores para output
GREEN='\033[0;32m'
BLUE='\033[0;34m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${BLUE}"
echo "╔════════════════════════════════════════════════════════════╗"
echo "║       INSTALADOR DE CHATBOT - EDDIS ALUMNOS              ║"
echo "╚════════════════════════════════════════════════════════════╝"
echo -e "${NC}"

# Directorio base
BASE_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
PAGES_DIR="$BASE_DIR/pages"

echo -e "${YELLOW}📂 Directorio de trabajo: $BASE_DIR${NC}"
echo ""

# Verificar que existen los archivos necesarios
if [ ! -f "$BASE_DIR/css/chatbot.css" ]; then
    echo -e "${RED}❌ Error: No se encuentra css/chatbot.css${NC}"
    exit 1
fi

if [ ! -f "$BASE_DIR/js/chatbot.js" ]; then
    echo -e "${RED}❌ Error: No se encuentra js/chatbot.js${NC}"
    exit 1
fi

if [ ! -f "$BASE_DIR/js/chatbot-config.json" ]; then
    echo -e "${RED}❌ Error: No se encuentra js/chatbot-config.json${NC}"
    exit 1
fi

echo -e "${GREEN}✅ Archivos del chatbot encontrados${NC}"
echo ""

# Función para agregar el chatbot a un archivo HTML
add_chatbot_to_file() {
    local file=$1
    local filename=$(basename "$file")
    
    echo -e "${BLUE}🔧 Procesando: $filename${NC}"
    
    # Verificar si ya tiene el chatbot instalado
    if grep -q "chatbot.css" "$file" && grep -q "chatbot.js" "$file"; then
        echo -e "${YELLOW}  ⚠️  El chatbot ya está instalado en este archivo${NC}"
        return
    fi
    
    # Crear backup
    cp "$file" "$file.backup"
    echo -e "${GREEN}  ✅ Backup creado: ${filename}.backup${NC}"
    
    # Agregar CSS antes de </head> si no existe
    if ! grep -q "chatbot.css" "$file"; then
        sed -i 's|</head>|  <!-- Chatbot Styles -->\n  <link rel="stylesheet" href="../css/chatbot.css">\n</head>|' "$file"
        echo -e "${GREEN}  ✅ CSS agregado${NC}"
    fi
    
    # Agregar JS antes de </body> si no existe
    if ! grep -q "chatbot.js" "$file"; then
        sed -i 's|</body>|  <!-- Chatbot Script -->\n  <script src="../js/chatbot.js"></script>\n</body>|' "$file"
        echo -e "${GREEN}  ✅ JavaScript agregado${NC}"
    fi
    
    echo -e "${GREEN}  ✨ ¡Chatbot instalado correctamente!${NC}"
    echo ""
}

# Contador de archivos procesados
count=0

# Procesar archivos HTML en el directorio pages
if [ -d "$PAGES_DIR" ]; then
    echo -e "${BLUE}📄 Buscando archivos HTML en pages/${NC}"
    echo ""
    
    for file in "$PAGES_DIR"/*.html; do
        if [ -f "$file" ]; then
            # Excluir chatbot-demo.html
            if [[ ! "$file" =~ chatbot-demo\.html$ ]]; then
                add_chatbot_to_file "$file"
                ((count++))
            fi
        fi
    done
else
    echo -e "${YELLOW}⚠️  No se encontró el directorio pages/${NC}"
fi

# Procesar archivos HTML en el directorio raíz
echo -e "${BLUE}📄 Buscando archivos HTML en la raíz${NC}"
echo ""

for file in "$BASE_DIR"/*.html; do
    if [ -f "$file" ]; then
        filename=$(basename "$file")
        if [[ ! "$filename" =~ chatbot-demo\.html$ ]]; then
            add_chatbot_to_file "$file"
            ((count++))
        fi
    fi
done

# Resumen
echo -e "${BLUE}"
echo "╔════════════════════════════════════════════════════════════╗"
echo "║                    INSTALACIÓN COMPLETA                   ║"
echo "╚════════════════════════════════════════════════════════════╝"
echo -e "${NC}"

if [ $count -eq 0 ]; then
    echo -e "${YELLOW}ℹ️  No se procesaron archivos${NC}"
else
    echo -e "${GREEN}✨ Chatbot instalado en $count archivo(s)${NC}"
    echo ""
    echo -e "${BLUE}📋 Próximos pasos:${NC}"
    echo "   1. Personaliza js/chatbot-config.json con tus preguntas"
    echo "   2. Actualiza el número de WhatsApp en js/chatbot.js"
    echo "   3. Personaliza los colores en css/chatbot.css (opcional)"
    echo "   4. Prueba el chatbot en chatbot-demo.html"
    echo ""
    echo -e "${YELLOW}💡 Los archivos originales se guardaron con extensión .backup${NC}"
    echo -e "${YELLOW}   Si algo sale mal, puedes restaurarlos${NC}"
fi

echo ""
echo -e "${GREEN}🎉 ¡Instalación completada!${NC}"
echo ""
