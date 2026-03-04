// Estado de la aplicación
let currentEntity = 'eddis';
let currentData = null;

// Inicialización
document.addEventListener('DOMContentLoaded', () => {
    initApp();
});

function initApp() {
    // Event listeners
    document.getElementById('entitySelect').addEventListener('change', handleEntityChange);
    document.getElementById('topicIcon').addEventListener('input', updateIconPreview);
    
    // Cargar datos iniciales
    loadData();
}

// Cargar datos del JSON
async function loadData() {
    showLoading();
    try {
        const entity = currentEntity;
        const configFile = entity === 'eddis' ? '../js/chatbot-config.json' : '../js/chatbot-config-studio.json';
        
        const response = await fetch(configFile);
        if (!response.ok) throw new Error('Error al cargar configuración');
        
        currentData = await response.json();
        
        // Cargar configuración general
        loadConfigForm();
        
        // Cargar temas
        renderTopics();
        
        hideLoading();
    } catch (error) {
        console.error('Error:', error);
        showToast('Error al cargar los datos', 'error');
        hideLoading();
    }
}

// Cargar formulario de configuración
function loadConfigForm() {
    if (!currentData || !currentData.config) return;
    
    document.getElementById('whatsappNumber').value = currentData.config.whatsappNumber || '';
    document.getElementById('whatsappMessage').value = currentData.config.whatsappMessage || '';
    document.getElementById('chatbotTitle').value = currentData.config.title || '';
    document.getElementById('chatbotSubtitle').value = currentData.config.subtitle || '';
}

// Guardar configuración general
async function saveConfig() {
    try {
        const config = {
            whatsappNumber: document.getElementById('whatsappNumber').value,
            whatsappMessage: document.getElementById('whatsappMessage').value,
            title: document.getElementById('chatbotTitle').value,
            subtitle: document.getElementById('chatbotSubtitle').value
        };
        
        currentData.config = config;
        
        console.log('Guardando configuración:', config);
        await saveToFile();
        showToast('Configuración guardada correctamente', 'success');
    } catch (error) {
        console.error('Error al guardar configuración:', error);
        showToast('Error al guardar la configuración: ' + error.message, 'error');
    }
}

// Renderizar temas
function renderTopics() {
    const container = document.getElementById('topicsList');
    
    if (!currentData || !currentData.topics || currentData.topics.length === 0) {
        container.innerHTML = `
            <div class="no-questions">
                <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 15px; opacity: 0.3;"></i>
                <p>No hay temas configurados. Haz clic en "Nuevo Tema" para crear uno.</p>
            </div>
        `;
        return;
    }
    
    container.innerHTML = currentData.topics.map((topic, index) => `
        <div class="topic-card">
            <div class="topic-header" onclick="toggleTopic(${index})">
                <div class="topic-info">
                    <div class="topic-icon-display">
                        <i class="fas ${topic.icon}"></i>
                    </div>
                    <div class="topic-details">
                        <h3>${topic.title}</h3>
                        <p>${topic.questions.length} pregunta(s) | ID: ${topic.id}</p>
                    </div>
                </div>
                <div class="topic-actions" onclick="event.stopPropagation()">
                    <button class="btn btn-sm btn-primary btn-icon" onclick="editTopic(${index})" title="Editar tema">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-sm btn-danger btn-icon" onclick="deleteTopic(${index})" title="Eliminar tema">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
            <div class="topic-content" id="topic-${index}" style="display: none;">
                <div style="margin-bottom: 15px;">
                    <button class="btn btn-sm btn-primary" onclick="openQuestionModal(${index})">
                        <i class="fas fa-plus"></i> Nueva Pregunta
                    </button>
                </div>
                ${renderQuestions(topic.questions, index)}
            </div>
        </div>
    `).join('');
}

// Renderizar preguntas de un tema
function renderQuestions(questions, topicIndex) {
    if (!questions || questions.length === 0) {
        return `
            <div class="no-questions">
                <p>No hay preguntas en este tema. Haz clic en "Nueva Pregunta" para agregar una.</p>
            </div>
        `;
    }
    
    return `
        <div class="questions-list">
            ${questions.map((q, qIndex) => `
                <div class="question-item">
                    <div class="question-header">
                        <div class="question-text">
                            <h4><i class="fas fa-question-circle"></i> ${q.question}</h4>
                            <p>${q.answer}</p>
                            <small style="color: #9ca3af; margin-top: 5px; display: block;">ID: ${q.id}</small>
                        </div>
                        <div class="question-actions">
                            <button class="btn btn-sm btn-primary btn-icon" onclick="editQuestion(${topicIndex}, ${qIndex})" title="Editar pregunta">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger btn-icon" onclick="deleteQuestion(${topicIndex}, ${qIndex})" title="Eliminar pregunta">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            `).join('')}
        </div>
    `;
}

// Toggle tema
function toggleTopic(index) {
    const content = document.getElementById(`topic-${index}`);
    if (content.style.display === 'none') {
        content.style.display = 'block';
    } else {
        content.style.display = 'none';
    }
}

// Modal de tema
function openTopicModal(index = -1) {
    const modal = document.getElementById('topicModal');
    const title = document.getElementById('topicModalTitle');
    
    if (index >= 0) {
        // Editar
        title.textContent = 'Editar Tema';
        const topic = currentData.topics[index];
        document.getElementById('topicIndex').value = index;
        document.getElementById('topicId').value = topic.id;
        document.getElementById('topicTitle').value = topic.title;
        document.getElementById('topicIcon').value = topic.icon;
        updateIconPreview();
    } else {
        // Nuevo
        title.textContent = 'Nuevo Tema';
        document.getElementById('topicIndex').value = '';
        document.getElementById('topicId').value = '';
        document.getElementById('topicTitle').value = '';
        document.getElementById('topicIcon').value = 'fa-star';
        updateIconPreview();
    }
    
    modal.classList.add('active');
}

function closeTopicModal() {
    document.getElementById('topicModal').classList.remove('active');
}

function editTopic(index) {
    openTopicModal(index);
}

async function deleteTopic(index) {
    if (!confirm('¿Estás seguro de eliminar este tema y todas sus preguntas?')) return;
    
    currentData.topics.splice(index, 1);
    await saveToFile();
    renderTopics();
    showToast('Tema eliminado correctamente', 'success');
}

async function saveTopic() {
    const index = document.getElementById('topicIndex').value;
    const topic = {
        id: document.getElementById('topicId').value.trim(),
        title: document.getElementById('topicTitle').value.trim(),
        icon: document.getElementById('topicIcon').value.trim(),
        questions: []
    };
    
    // Validaciones
    if (!topic.id || !topic.title || !topic.icon) {
        showToast('Por favor completa todos los campos', 'error');
        return;
    }
    
    if (!/^[a-z0-9-]+$/.test(topic.id)) {
        showToast('El ID solo puede contener letras minúsculas, números y guiones', 'error');
        return;
    }
    
    if (index === '') {
        // Nuevo tema
        topic.questions = [];
        currentData.topics.push(topic);
    } else {
        // Editar tema (mantener preguntas existentes)
        topic.questions = currentData.topics[index].questions;
        currentData.topics[index] = topic;
    }
    
    await saveToFile();
    closeTopicModal();
    renderTopics();
    showToast('Tema guardado correctamente', 'success');
}

// Modal de pregunta
function openQuestionModal(topicIndex, questionIndex = -1) {
    const modal = document.getElementById('questionModal');
    const title = document.getElementById('questionModalTitle');
    
    document.getElementById('questionTopicIndex').value = topicIndex;
    
    if (questionIndex >= 0) {
        // Editar
        title.textContent = 'Editar Pregunta';
        const question = currentData.topics[topicIndex].questions[questionIndex];
        document.getElementById('questionIndex').value = questionIndex;
        document.getElementById('questionId').value = question.id;
        document.getElementById('questionText').value = question.question;
        document.getElementById('answerText').value = question.answer;
    } else {
        // Nueva
        title.textContent = 'Nueva Pregunta';
        document.getElementById('questionIndex').value = '';
        document.getElementById('questionId').value = '';
        document.getElementById('questionText').value = '';
        document.getElementById('answerText').value = '';
    }
    
    modal.classList.add('active');
}

function closeQuestionModal() {
    document.getElementById('questionModal').classList.remove('active');
}

function editQuestion(topicIndex, questionIndex) {
    openQuestionModal(topicIndex, questionIndex);
}

async function deleteQuestion(topicIndex, questionIndex) {
    if (!confirm('¿Estás seguro de eliminar esta pregunta?')) return;
    
    currentData.topics[topicIndex].questions.splice(questionIndex, 1);
    await saveToFile();
    renderTopics();
    showToast('Pregunta eliminada correctamente', 'success');
}

async function saveQuestion() {
    const topicIndex = parseInt(document.getElementById('questionTopicIndex').value);
    const questionIndex = document.getElementById('questionIndex').value;
    
    const question = {
        id: document.getElementById('questionId').value.trim(),
        question: document.getElementById('questionText').value.trim(),
        answer: document.getElementById('answerText').value.trim()
    };
    
    // Validaciones
    if (!question.id || !question.question || !question.answer) {
        showToast('Por favor completa todos los campos', 'error');
        return;
    }
    
    if (!/^[a-z0-9-]+$/.test(question.id)) {
        showToast('El ID solo puede contener letras minúsculas, números y guiones', 'error');
        return;
    }
    
    if (questionIndex === '') {
        // Nueva pregunta
        currentData.topics[topicIndex].questions.push(question);
    } else {
        // Editar pregunta
        currentData.topics[topicIndex].questions[questionIndex] = question;
    }
    
    await saveToFile();
    closeQuestionModal();
    renderTopics();
    
    // Mantener el tema expandido
    document.getElementById(`topic-${topicIndex}`).style.display = 'block';
    
    showToast('Pregunta guardada correctamente', 'success');
}

// Guardar en archivo
async function saveToFile() {
    showLoading();
    try {
        const entity = currentEntity;
        
        console.log('Guardando en archivo:', entity);
        console.log('Datos a guardar:', currentData);
        
        const response = await fetch('api/save.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                entity: entity,
                data: currentData
            })
        });
        
        console.log('Respuesta del servidor:', response);
        
        if (!response.ok) {
            const errorText = await response.text();
            console.error('Error del servidor:', errorText);
            throw new Error(`Error HTTP ${response.status}: ${errorText}`);
        }
        
        const result = await response.json();
        console.log('Resultado:', result);
        
        if (!result.success) {
            throw new Error(result.message || 'Error al guardar');
        }
        
        hideLoading();
        return result;
    } catch (error) {
        console.error('Error en saveToFile:', error);
        hideLoading();
        throw error;
    }
}

// Cambiar entidad
function handleEntityChange(e) {
    currentEntity = e.target.value;
    loadData();
}

// Actualizar preview de ícono
function updateIconPreview() {
    const icon = document.getElementById('topicIcon').value;
    document.getElementById('iconPreview').className = `fas ${icon}`;
}

// Utilidades UI
function showLoading() {
    document.getElementById('loadingOverlay').classList.remove('hidden');
}

function hideLoading() {
    document.getElementById('loadingOverlay').classList.add('hidden');
}

function showToast(message, type = 'success') {
    const toast = document.getElementById('toast');
    toast.textContent = message;
    toast.className = `toast show ${type}`;
    
    setTimeout(() => {
        toast.classList.remove('show');
    }, 3000);
}
