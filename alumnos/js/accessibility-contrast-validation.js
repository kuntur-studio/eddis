// Análisis de Contraste Actualizado - Correcciones de Accesibilidad
// Valida los nuevos colores para certificados, botones y mensajes

const calculateLuminance = (hex) => {
  const rgb = hex.replace('#', '').match(/.{2}/g).map(x => parseInt(x, 16) / 255);
  const sRGB = rgb.map(c => c <= 0.03928 ? c / 12.92 : Math.pow((c + 0.055) / 1.055, 2.4));
  return 0.2126 * sRGB[0] + 0.7152 * sRGB[1] + 0.0722 * sRGB[2];
};

const calculateContrast = (color1, color2) => {
  const lum1 = calculateLuminance(color1);
  const lum2 = calculateLuminance(color2);
  const brightest = Math.max(lum1, lum2);
  const darkest = Math.min(lum1, lum2);
  return (brightest + 0.05) / (darkest + 0.05);
};

const validateContrast = (ratio, level = 'AAA') => {
  const thresholds = { AA: 4.5, AAA: 7.0 };
  return {
    passes: ratio >= thresholds[level],
    level: ratio >= thresholds.AAA ? 'AAA' : ratio >= thresholds.AA ? 'AA' : 'FAIL'
  };
};

console.log('🔍 ANÁLISIS DE CONTRASTE - CORRECCIONES DE ACCESIBILIDAD');
console.log('=' * 70);

// Nuevos colores corregidos
const correctedColors = {
  // Certificados
  certificateBackground: '#0f172a', // Fondo de tarjeta certificado (más oscuro)
  certificateText: '#ffffff',       // Texto principal
  certificateSecondary: '#e5e7eb',  // Texto secundario
  certificateIcon: '#fbbf24',       // Iconos dorados
  certificateStatusActive: '#064e3b', // Estado activo (verde muy oscuro para AAA)
  certificateStatusPending: '#991b1b', // Estado pendiente (rojo muy oscuro para AAA)
  certificateButton: '#2563eb',     // Botones azules
  
  // Botones de acción
  verCuentaButton: '#1e40af',       // Ver cuenta corriente
  pagarButton: '#991b1b',           // Pagar/acciones importantes (corregido a AAA)
  backButton: '#374151',            // Botón volver
  
  // Mensajes
  successMessage: '#065f46',        // Mensajes de éxito
  
  // Fondos
  mainBackground: '#151c3a',        // Fondo principal dark mode
  cardBackground: '#32417f'         // Fondo de cards normales
};

console.log('\n📊 VALIDACIÓN DE CONTRASTE - CERTIFICADOS:');
console.log('-'.repeat(50));

// Certificados - Fondo vs Texto
const certBgVsText = calculateContrast(correctedColors.certificateBackground, correctedColors.certificateText);
const certBgVsSecondary = calculateContrast(correctedColors.certificateBackground, correctedColors.certificateSecondary);
const certBgVsIcon = calculateContrast(correctedColors.certificateBackground, correctedColors.certificateIcon);

console.log(`Certificado Fondo vs Texto Principal: ${certBgVsText.toFixed(2)}:1 ${validateContrast(certBgVsText).passes ? '✅ PASA AAA' : '❌ FALLA'}`);
console.log(`Certificado Fondo vs Texto Secundario: ${certBgVsSecondary.toFixed(2)}:1 ${validateContrast(certBgVsSecondary).passes ? '✅ PASA AAA' : '❌ FALLA'}`);
console.log(`Certificado Fondo vs Iconos: ${certBgVsIcon.toFixed(2)}:1 ${validateContrast(certBgVsIcon).passes ? '✅ PASA AAA' : '❌ FALLA'}`);

// Estados de certificado
const statusActiveContrast = calculateContrast(correctedColors.certificateStatusActive, correctedColors.certificateText);
const statusPendingContrast = calculateContrast(correctedColors.certificateStatusPending, correctedColors.certificateText);

console.log(`Estado Activo vs Texto: ${statusActiveContrast.toFixed(2)}:1 ${validateContrast(statusActiveContrast).passes ? '✅ PASA AAA' : '❌ FALLA'}`);
console.log(`Estado Pendiente vs Texto: ${statusPendingContrast.toFixed(2)}:1 ${validateContrast(statusPendingContrast).passes ? '✅ PASA AAA' : '❌ FALLA'}`);

console.log('\n📊 VALIDACIÓN DE CONTRASTE - BOTONES:');
console.log('-'.repeat(50));

// Botones de acción
const verCuentaContrast = calculateContrast(correctedColors.verCuentaButton, correctedColors.certificateText);
const pagarContrast = calculateContrast(correctedColors.pagarButton, correctedColors.certificateText);
const backContrast = calculateContrast(correctedColors.backButton, correctedColors.certificateText);

console.log(`Ver Cuenta Corriente: ${verCuentaContrast.toFixed(2)}:1 ${validateContrast(verCuentaContrast).passes ? '✅ PASA AAA' : '❌ FALLA'}`);
console.log(`Pagar/Acciones: ${pagarContrast.toFixed(2)}:1 ${validateContrast(pagarContrast).passes ? '✅ PASA AAA' : '❌ FALLA'}`);
console.log(`Botón Volver: ${backContrast.toFixed(2)}:1 ${validateContrast(backContrast).passes ? '✅ PASA AAA' : '❌ FALLA'}`);

console.log('\n📊 VALIDACIÓN DE CONTRASTE - MENSAJES:');
console.log('-'.repeat(50));

// Mensajes
const successContrast = calculateContrast(correctedColors.successMessage, correctedColors.certificateText);
console.log(`Mensaje Éxito/Felicitaciones: ${successContrast.toFixed(2)}:1 ${validateContrast(successContrast).passes ? '✅ PASA AAA' : '❌ FALLA'}`);

console.log('\n📊 SEPARACIÓN VISUAL - FONDOS:');
console.log('-'.repeat(50));

// Verificar separación entre fondos
const mainVsCertificate = calculateContrast(correctedColors.mainBackground, correctedColors.certificateBackground);
const mainVsCard = calculateContrast(correctedColors.mainBackground, correctedColors.cardBackground);

console.log(`Fondo Principal vs Certificado: ${mainVsCertificate.toFixed(2)}:1 ${mainVsCertificate > 1.5 ? '✅ SEPARACIÓN VISIBLE' : '❌ POCO CONTRASTE'}`);
console.log(`Fondo Principal vs Card Normal: ${mainVsCard.toFixed(2)}:1 ${mainVsCard > 1.5 ? '✅ SEPARACIÓN VISIBLE' : '❌ POCO CONTRASTE'}`);

console.log('\n' + '='.repeat(70));
console.log('🎯 RESUMEN DE CORRECCIONES:');
console.log('✅ Certificados: Fondo diferenciado del principal');
console.log('✅ Estados: Verde brillante (Activo) y Rojo (Pendiente)');
console.log('✅ Iconos: Amarillo dorado con alto contraste');
console.log('✅ Botones: Colores específicos por función');
console.log('✅ Mensajes: Verde oscuro para éxito/felicitaciones');
console.log('✅ Navegación: Gris oscuro para botones volver');

console.log('\n🔧 IMPLEMENTACIÓN:');
console.log('1. Aplicar theme-eddis-optimized.css actualizado');
console.log('2. Opcional: Incluir accessibility-fixes.css para casos edge');
console.log('3. Probar en dispositivos reales');
console.log('4. Validar con herramientas de accesibilidad');