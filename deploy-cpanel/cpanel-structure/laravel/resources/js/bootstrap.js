import axios from 'axios';
window.axios = axios;

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

// Configurar token CSRF para todas las peticiones AJAX
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

// Interceptor para manejar errores globalmente
window.axios.interceptors.response.use(
    response => response,
    error => {
        if (error.response) {
            switch (error.response.status) {
                case 401:
                    // No autorizado - redirigir al login
                    window.location.href = '/login';
                    break;
                case 403:
                    // Prohibido
                    console.error('Acceso prohibido');
                    break;
                case 404:
                    // No encontrado
                    console.error('Recurso no encontrado');
                    break;
                case 422:
                    // Errores de validación
                    console.error('Errores de validación:', error.response.data.errors);
                    break;
                case 500:
                    // Error del servidor
                    console.error('Error interno del servidor');
                    break;
                default:
                    console.error('Error:', error.response.data.message || 'Error desconocido');
            }
        }
        return Promise.reject(error);
    }
);