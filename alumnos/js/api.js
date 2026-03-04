// API Configuration - Single Endpoint
const API_BASE_URL = window.location.hostname === "localhost" || window.location.hostname === "127.0.0.1" 
  ? "http://localhost/eddis/api" 
  : "https://servidoreddis.com.ar/api"

// Countries Configuration
const COUNTRIES = {
  argentina: {
    code: "argentina",
    name: "Argentina",
    flag: "🇦🇷",
  },
  uruguay: {
    code: "uruguay",
    name: "Uruguay",
    flag: "🇺🇾",
  },
  paraguay: {
    code: "paraguay",
    name: "Paraguay",
    flag: "🇵🇾",
  },
  studio_beauty: {
    code: "studio_beauty",
    name: "Studio Beauty",
    flag: "💄",
  },
}

// Simple API Service
class ApiService {
  constructor() {
    this.baseURL = API_BASE_URL
  }

  // Get auth token from localStorage
  getAuthToken() {
    return localStorage.getItem("authToken")
  }

  // Set auth token in localStorage
  setAuthToken(token) {
    localStorage.setItem("authToken", token)
  }

  // Remove auth token from localStorage
  removeAuthToken() {
    localStorage.removeItem("authToken")
  }

  // Check if user is authenticated
  isAuthenticated() {
    return !!this.getAuthToken()
  }

  // Build headers for API requests
  buildHeaders(includeAuth = false) {
    const headers = {
      "Content-Type": "application/json",
    }

    if (includeAuth) {
      const token = this.getAuthToken()
      if (token) {
        headers["Authorization"] = `Bearer ${token}`
      }
    }

    return headers
  }

  // Generic API request method
  async makeRequest(endpoint, options = {}) {
    const url = `${this.baseURL}${endpoint}`

    try {
      const response = await fetch(url, {
        ...options,
        headers: {
          ...this.buildHeaders(options.includeAuth),
          ...options.headers,
        },
      })

      if (!response.ok) {
        const errorData = await response.json().catch(() => ({}))
        throw new ApiError(errorData.message || "Error en la petición", response.status, errorData)
      }

      return await response.json()
    } catch (error) {
      if (error instanceof ApiError) {
        throw error
      }
      throw new ApiError("Error de conexión. Verifica tu conexión a internet.", 0, { originalError: error.message })
    }
  }

  // Cambiar el método login para usar GET con parámetros en la URL
  async login(legajo, documento, pais) {
    // Construir la URL con parámetros GET
    const params = new URLSearchParams({
      legajo: legajo,
      documento: documento,
      pais: pais,
    })

    const url = `${this.baseURL}/auth/login.php?${params.toString()}`

    try {
      // DEBUG: Mostrar la URL exacta que se usará en el login
      console.log('[LOGIN DEBUG] URL de login:', url);
      const response = await fetch(url, {
        method: "GET",
        headers: {
          "Content-Type": "application/json",
        },
      })

      if (!response.ok) {
        const errorData = await response.json().catch(() => ({}))
        throw new ApiError(errorData.message || "Error en la petición", response.status, errorData)
      }

      const data = await response.json()

      if (data.success && data.token) {
        this.setAuthToken(data.token)
        // Store selected country for session
        localStorage.setItem("selectedCountry", pais)
      }

      return data
    } catch (error) {
      if (error instanceof ApiError) {
        throw error
      }
      throw new ApiError("Error de conexión. Verifica tu conexión a internet.", 0, { originalError: error.message })
    }
  }

  // Get student data - includes country in body
  async getAlumnoData() {
    const country = localStorage.getItem("selectedCountry");
    const token = this.getAuthToken();
    const params = new URLSearchParams({ pais: country, token }).toString();
     console.log(" Enviando a /alumnos/datos.php con GET:", params);
    return await this.makeRequest(`/alumnos/datos.php?${params}`, {
      method: "GET"
    });
  }


  async getCursoData(idcur) {
    console.log('[API DEBUG] Entrando a getCursoData');
    console.log('[API DEBUG] ID del curso:', idcur);

    const country = localStorage.getItem("selectedCountry");
    const token = this.getAuthToken();
    
    console.log('[API DEBUG] País seleccionado:', country);
    console.log('[API DEBUG] Token presente:', !!token);

    if (!country || !token || !idcur) {
      console.error('[API ERROR] Faltan parámetros necesarios:', {
        countryPresent: !!country,
        tokenPresent: !!token,
        idPresent: !!idcur
      });
      throw new ApiError('Faltan parámetros necesarios para obtener datos del curso', 400);
    }

    const params = new URLSearchParams({ pais: country, token, idcur }).toString();
    const url = `/cursos/datos.php?${params}`;
    
    console.log('[API DEBUG] URL completa:', url);
    console.log('[API DEBUG] Parámetros:', { pais: country, token: token ? '***' : null, idcur });

    try {
      const data = await this.makeRequest(url, {
        method: "GET"
      });
      
      console.log('[API DEBUG] Respuesta recibida:', data);
      console.log('[API DEBUG] Tipo de respuesta:', typeof data);
      
      if (!data || !data.success) {
        console.error('[API ERROR] Respuesta inválida:', data);
        throw new ApiError('Respuesta inválida de la API', 400, data);
      }

      console.log('[API DEBUG] Datos del curso:', data);
      return data;
    } catch (error) {
      console.error('[API ERROR] Error en getCursoData:', {
        message: error.message,
        status: error.status,
        data: error.data
      });
      throw error;
    }
  }




  // Get current country
  getCurrentCountry() {
    return localStorage.getItem("selectedCountry") || "argentina"
  }

  // Get novedades/publicaciones data
  async getNovedadesData() {
    const country = localStorage.getItem("selectedCountry");
    const token = this.getAuthToken();
    const params = new URLSearchParams({ pais: country, token }).toString();
    console.log("[API DEBUG] Enviando a /novedades/datos.php con GET:", params);
    return await this.makeRequest(`/novedades/datos.php?${params}`, {
      method: "GET"
    });
  }

  // Save alumno data (telefono y email)
  async saveAlumnoData(telefono, email) {
    const country = localStorage.getItem("selectedCountry");
    const token = this.getAuthToken();
    
    console.log('[DATOS DEBUG] ========== INICIO GUARDADO DE DATOS ==========');
    console.log('[DATOS DEBUG] País:', country);
    console.log('[DATOS DEBUG] Token presente:', !!token);
    console.log('[DATOS DEBUG] Token (primeros 20 chars):', token ? token.substring(0, 20) + '...' : 'null');
    console.log('[DATOS DEBUG] Datos a guardar:', { telefono, email });
    
    const formData = new FormData();
    formData.append('pais', country);
    formData.append('token', token);
    formData.append('telefono', telefono);
    formData.append('email', email);

    console.log('[DATOS DEBUG] FormData enviado:');
    for (let [key, value] of formData.entries()) {
      console.log(`  ${key}:`, value);
    }

    const url = `${this.baseURL}/alumnos/alumnos_save.php`;
    console.log('[DATOS DEBUG] URL destino:', url);
    
    try {
      console.log('[DATOS DEBUG] Enviando petición POST...');
      const response = await fetch(url, {
        method: "POST",
        body: formData
      });

      console.log('[DATOS DEBUG] Respuesta recibida:');
      console.log('[DATOS DEBUG] Status:', response.status);
      console.log('[DATOS DEBUG] Status Text:', response.statusText);

      if (!response.ok) {
        const errorData = await response.json().catch(() => ({}));
        console.error('[DATOS DEBUG] Error en respuesta:', errorData);
        throw new ApiError(errorData.message || "Error al guardar los datos", response.status, errorData);
      }

      const jsonResponse = await response.json();
      console.log('[DATOS DEBUG] Respuesta JSON:', jsonResponse);
      console.log('[DATOS DEBUG] ========== FIN GUARDADO DE DATOS ==========');
      
      return jsonResponse;
    } catch (error) {
      console.error('[DATOS DEBUG] ========== ERROR EN GUARDADO DE DATOS ==========');
      console.error('[DATOS DEBUG] Tipo de error:', error.constructor.name);
      console.error('[DATOS DEBUG] Mensaje:', error.message);
      
      if (error instanceof ApiError) {
        throw error;
      }
      throw new ApiError("Error de conexión al guardar datos.", 0, { originalError: error.message });
    }
  }

  // Save alumno photo
  async saveAlumnoPhoto(photoFile) {
    const country = localStorage.getItem("selectedCountry");
    const token = this.getAuthToken();
    
    console.log('[FOTO DEBUG] ========== INICIO GUARDADO DE FOTO ==========');
    console.log('[FOTO DEBUG] País:', country);
    console.log('[FOTO DEBUG] Token presente:', !!token);
    console.log('[FOTO DEBUG] Token (primeros 20 chars):', token ? token.substring(0, 20) + '...' : 'null');
    console.log('[FOTO DEBUG] Archivo:', {
      nombre: photoFile.name,
      tipo: photoFile.type,
      tamaño: photoFile.size + ' bytes',
      tamañoMB: (photoFile.size / 1024 / 1024).toFixed(2) + ' MB'
    });
    
    const formData = new FormData();
    formData.append('pais', country);
    formData.append('token', token);
    formData.append('fotoperfil', photoFile);

    // Log de lo que se envía
    console.log('[FOTO DEBUG] FormData enviado:');
    for (let [key, value] of formData.entries()) {
      if (key === 'fotoperfil') {
        console.log(`  ${key}:`, {
          nombre: value.name,
          tipo: value.type,
          tamaño: value.size
        });
      } else {
        console.log(`  ${key}:`, value);
      }
    }

    const url = `${this.baseURL}/alumnos/alumnos_foto.php`;
    console.log('[FOTO DEBUG] URL destino:', url);
    
    try {
      console.log('[FOTO DEBUG] Enviando petición POST...');
      const response = await fetch(url, {
        method: "POST",
        body: formData
      });

      console.log('[FOTO DEBUG] Respuesta recibida:');
      console.log('[FOTO DEBUG] Status:', response.status);
      console.log('[FOTO DEBUG] Status Text:', response.statusText);
      console.log('[FOTO DEBUG] Headers:', Object.fromEntries(response.headers.entries()));

      if (!response.ok) {
        const errorData = await response.json().catch(() => ({}));
        console.error('[FOTO DEBUG] Error en respuesta:', errorData);
        throw new ApiError(errorData.message || "Error al guardar la foto", response.status, errorData);
      }

      const jsonResponse = await response.json();
      console.log('[FOTO DEBUG] Respuesta JSON:', jsonResponse);
      console.log('[FOTO DEBUG] ========== FIN GUARDADO DE FOTO ==========');
      
      return jsonResponse;
    } catch (error) {
      console.error('[FOTO DEBUG] ========== ERROR EN GUARDADO DE FOTO ==========');
      console.error('[FOTO DEBUG] Tipo de error:', error.constructor.name);
      console.error('[FOTO DEBUG] Mensaje:', error.message);
      console.error('[FOTO DEBUG] Stack:', error.stack);
      
      if (error instanceof ApiError) {
        throw error;
      }
      throw new ApiError("Error de conexión al guardar la foto.", 0, { originalError: error.message });
    }
  }

  // Logout method
  logout() {
    this.removeAuthToken()
    localStorage.removeItem("selectedCountry")
  }
}

// Custom API Error class
class ApiError extends Error {
  constructor(message, status, data = {}) {
    super(message)
    this.name = "ApiError"
    this.status = status
    this.data = data
  }

  isUnauthorized() {
    return this.status === 401
  }

  isBadRequest() {
    return this.status === 400
  }

  isServerError() {
    return this.status >= 500
  }
}

// Create and export API service instance
const apiService = new ApiService()

export { apiService, ApiError, COUNTRIES }
