// Validador de Flujo JS-CSS - Dark Mode EDDIS Platform
// Verifica coherencia entre darkmode-manager.js y CSS optimizados

const fs = require('fs');

console.log('🔄 VALIDACIÓN DE FLUJO JS ↔ CSS - DARK MODE');
console.log('='.repeat(60));

// 1. Verificar que darkmode-manager.js use las clases correctas
const validateJavaScript = () => {
    console.log('\n📜 VALIDANDO JAVASCRIPT:');
    
    try {
        const jsContent = fs.readFileSync('c:\\xampp\\htdocs\\eddisplat\\js\\darkmode-manager.js', 'utf8');
        
        // Verificar uso de body.dark
        const bodyDarkUsage = jsContent.includes('body.classList') || jsContent.includes('this.body.classList');
        const correctToggle = jsContent.includes('classList.toggle') && jsContent.includes('DARK_CLASS');
        
        console.log(`   ✅ Uso correcto de body.dark: ${bodyDarkUsage ? 'SÍ' : 'NO'}`);
        console.log(`   ✅ Toggle correcto de clase: ${correctToggle ? 'SÍ' : 'NO'}`);
        
        // Verificar consistencia en localStorage
        const localStorageKey = jsContent.match(/localStorage\.(?:get|set)Item\('([^']+)'/g);
        if (localStorageKey) {
            console.log(`   ✅ Clave localStorage: ${localStorageKey[0].split("'")[1]}`);
        }
        
        // Verificar logo switching
        const logoLogic = jsContent.includes('updateLogo') && jsContent.includes('eddis') && jsContent.includes('studio');
        console.log(`   ✅ Lógica de logos: ${logoLogic ? 'IMPLEMENTADA' : 'FALTANTE'}`);
        
        return {
            bodyDarkUsage,
            correctToggle,
            logoLogic,
            valid: bodyDarkUsage && correctToggle && logoLogic
        };
        
    } catch (error) {
        console.error('   ❌ Error validando JavaScript:', error.message);
        return { valid: false };
    }
};

// 2. Verificar CSS optimizados
const validateCSS = () => {
    console.log('\n🎨 VALIDANDO CSS OPTIMIZADOS:');
    
    const cssFiles = [
        { name: 'EDDIS', path: 'c:\\xampp\\htdocs\\eddisplat\\css\\theme-eddis-optimized.css' },
        { name: 'Studio Beauty', path: 'c:\\xampp\\htdocs\\eddisplat\\css\\theme-studiobeauty-optimized.css' }
    ];
    
    const results = {};
    
    cssFiles.forEach(({ name, path }) => {
        try {
            const cssContent = fs.readFileSync(path, 'utf8');
            
            // Verificar selectores body.dark
            const bodyDarkSelectors = (cssContent.match(/body\.dark/g) || []).length;
            const standaloneRDarkSelectors = (cssContent.match(/^\.dark\s*{/gm) || []).length;
            
            // Verificar variables CSS
            const cssVariables = (cssContent.match(/var\(--[^)]+\)/g) || []).length;
            const darkModeVars = cssContent.includes('--bg-dark') && cssContent.includes('--text-dark');
            
            // Verificar transiciones
            const transitions = cssContent.includes('transition:') || cssContent.includes('transition ');
            
            console.log(`   📁 ${name}:`);
            console.log(`      • Selectores body.dark: ${bodyDarkSelectors}`);
            console.log(`      • Selectores .dark solos: ${standaloneRDarkSelectors}`);
            console.log(`      • Variables CSS: ${cssVariables}`);
            console.log(`      • Variables dark mode: ${darkModeVars ? 'SÍ' : 'NO'}`);
            console.log(`      • Transiciones: ${transitions ? 'SÍ' : 'NO'}`);
            
            results[name] = {
                bodyDarkSelectors,
                standaloneRDarkSelectors,
                cssVariables,
                darkModeVars,
                transitions,
                valid: bodyDarkSelectors > 0 && darkModeVars && transitions
            };
            
        } catch (error) {
            console.error(`   ❌ Error validando ${name}:`, error.message);
            results[name] = { valid: false };
        }
    });
    
    return results;
};

// 3. Verificar coherencia de colores entre temas
const validateColorConsistency = () => {
    console.log('\n🌈 VALIDANDO COHERENCIA DE COLORES:');
    
    try {
        const eddisCSS = fs.readFileSync('c:\\xampp\\htdocs\\eddisplat\\css\\theme-eddis-optimized.css', 'utf8');
        const studioCSS = fs.readFileSync('c:\\xampp\\htdocs\\eddisplat\\css\\theme-studiobeauty-optimized.css', 'utf8');
        
        // Extraer variables dark mode
        const extractDarkVars = (css) => {
            const vars = {};
            const matches = css.match(/--[a-z-]+:\s*[^;]+;/g) || [];
            matches.forEach(match => {
                const [key, value] = match.split(':').map(s => s.trim());
                if (key.includes('dark') || key.includes('text')) {
                    vars[key] = value.replace(';', '');
                }
            });
            return vars;
        };
        
        const eddisVars = extractDarkVars(eddisCSS);
        const studioVars = extractDarkVars(studioCSS);
        
        console.log('   📊 Variables de color EDDIS:');
        Object.entries(eddisVars).forEach(([key, value]) => {
            console.log(`      ${key}: ${value}`);
        });
        
        console.log('   📊 Variables de color Studio Beauty:');
        Object.entries(studioVars).forEach(([key, value]) => {
            console.log(`      ${key}: ${value}`);
        });
        
        // Verificar que ambos temas tienen variables esenciales
        const essentialVars = ['--bg-dark', '--text-dark', '--text-dark-secondary'];
        const eddisHasEssential = essentialVars.every(v => v in eddisVars);
        const studioHasEssential = essentialVars.every(v => v in studioVars);
        
        console.log(`   ✅ EDDIS tiene variables esenciales: ${eddisHasEssential ? 'SÍ' : 'NO'}`);
        console.log(`   ✅ Studio Beauty tiene variables esenciales: ${studioHasEssential ? 'SÍ' : 'NO'}`);
        
        return {
            eddisVars,
            studioVars,
            eddisHasEssential,
            studioHasEssential,
            valid: eddisHasEssential && studioHasEssential
        };
        
    } catch (error) {
        console.error('   ❌ Error validando coherencia de colores:', error.message);
        return { valid: false };
    }
};

// 4. Ejecutar todas las validaciones
const runAllValidations = () => {
    const jsValidation = validateJavaScript();
    const cssValidation = validateCSS();
    const colorValidation = validateColorConsistency();
    
    console.log('\n' + '='.repeat(60));
    console.log('📋 RESUMEN DE VALIDACIÓN:');
    
    const allValid = jsValidation.valid && 
                    Object.values(cssValidation).every(v => v.valid) && 
                    colorValidation.valid;
    
    console.log(`JavaScript: ${jsValidation.valid ? '✅ VÁLIDO' : '❌ REQUIERE AJUSTES'}`);
    console.log(`CSS EDDIS: ${cssValidation.EDDIS?.valid ? '✅ VÁLIDO' : '❌ REQUIERE AJUSTES'}`);
    console.log(`CSS Studio Beauty: ${cssValidation['Studio Beauty']?.valid ? '✅ VÁLIDO' : '❌ REQUIERE AJUSTES'}`);
    console.log(`Coherencia de colores: ${colorValidation.valid ? '✅ VÁLIDA' : '❌ REQUIERE AJUSTES'}`);
    
    console.log(`\n🎯 ESTADO GENERAL: ${allValid ? '✅ OPTIMIZACIÓN COMPLETA' : '⚠️ REQUIERE AJUSTES'}`);
    
    if (allValid) {
        console.log('\n🚀 IMPLEMENTACIÓN RECOMENDADA:');
        console.log('1. Reemplazar archivos CSS originales con versiones optimizadas');
        console.log('2. Verificar funcionamiento en navegadores objetivo');
        console.log('3. Realizar pruebas de accesibilidad con lectores de pantalla');
        console.log('4. Monitorear rendimiento de transiciones CSS');
    }
    
    return allValid;
};

// Ejecutar validación completa
runAllValidations();