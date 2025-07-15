import './bootstrap';
// import Alpine from 'alpinejs'; // Comentado para que Livewire maneje Alpine

// Configuración global de Alpine.js
// window.Alpine = Alpine; // Comentado para que Livewire maneje Alpine
// Alpine.start(); // Livewire se encarga de iniciar Alpine si es necesario, o se inicia al importar.

// Configuración global de la aplicación
window.App = {
    // Configuraciones
    config: {
        apiUrl: window.location.origin + '/api',
        csrfToken: document.querySelector('meta[name="csrf-token"]')?.getAttribute('content'),
        locale: document.documentElement.lang || 'es',
    },

    // Utilidades globales
    utils: {
        // Formatear fecha
        formatDate: (date, options = {}) => {
            const defaultOptions = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            return new Intl.DateTimeFormat(App.config.locale, { ...defaultOptions, ...options }).format(new Date(date));
        },

        // Formatear moneda
        formatCurrency: (amount, currency = 'MXN') => {
            return new Intl.NumberFormat(App.config.locale, {
                style: 'currency',
                currency: currency
            }).format(amount);
        },

        // Debounce function
        debounce: (func, wait) => {
            let timeout;
            return function executedFunction(...args) {
                const later = () => {
                    clearTimeout(timeout);
                    func(...args);
                };
                clearTimeout(timeout);
                timeout = setTimeout(later, wait);
            };
        },

        // Mostrar notificación
        showNotification: (message, type = 'info', duration = 5000) => {
            const notification = document.createElement('div');
            notification.className = `notification notification-${type} fixed top-4 right-4 z-50 p-4 rounded-lg shadow-lg max-w-sm`;
            notification.innerHTML = `
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        ${App.utils.getNotificationIcon(type)}
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium">${message}</p>
                    </div>
                    <div class="ml-auto pl-3">
                        <button onclick="this.parentElement.parentElement.parentElement.remove()" class="text-gray-400 hover:text-gray-600">
                            <span class="sr-only">Cerrar</span>
                            <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            `;
            
            document.body.appendChild(notification);
            
            // Auto-remove después del tiempo especificado
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.remove();
                }
            }, duration);
        },

        // Obtener icono para notificación
        getNotificationIcon: (type) => {
            const icons = {
                success: '<svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" /></svg>',
                error: '<svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" /></svg>',
                warning: '<svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" /></svg>',
                info: '<svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" /></svg>'
            };
            return icons[type] || icons.info;
        },

        // Validar email
        validateEmail: (email) => {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        },

        // Validar teléfono mexicano
        validatePhoneMX: (phone) => {
            const re = /^(\+52|52)?[\s\-]?[1-9]\d{9}$/;
            return re.test(phone.replace(/\s/g, ''));
        },

        // Formatear teléfono
        formatPhone: (phone) => {
            const cleaned = phone.replace(/\D/g, '');
            if (cleaned.length === 10) {
                return cleaned.replace(/(\d{3})(\d{3})(\d{4})/, '($1) $2-$3');
            }
            return phone;
        },

        // Copiar al portapapeles
        copyToClipboard: async (text) => {
            try {
                await navigator.clipboard.writeText(text);
                App.utils.showNotification('Copiado al portapapeles', 'success');
                return true;
            } catch (err) {
                console.error('Error al copiar:', err);
                App.utils.showNotification('Error al copiar', 'error');
                return false;
            }
        },

        // Confirmar acción
        confirm: (message, callback) => {
            if (window.confirm(message)) {
                callback();
            }
        }
    },

    // Componentes Alpine.js reutilizables
    components: {
        // Modal
        modal: () => ({
            show: false,
            open() {
                this.show = true;
                document.body.style.overflow = 'hidden';
            },
            close() {
                this.show = false;
                document.body.style.overflow = 'auto';
            }
        }),

        // Dropdown
        dropdown: () => ({
            open: false,
            toggle() {
                this.open = !this.open;
            },
            close() {
                this.open = false;
            }
        }),

        // Tabs
        tabs: (defaultTab = 0) => ({
            activeTab: defaultTab,
            setActiveTab(index) {
                this.activeTab = index;
            }
        }),

        // Form validation
        form: () => ({
            errors: {},
            loading: false,
            validateField(field, value, rules) {
                this.errors[field] = [];
                
                rules.forEach(rule => {
                    if (rule === 'required' && !value) {
                        this.errors[field].push('Este campo es requerido');
                    }
                    if (rule === 'email' && value && !App.utils.validateEmail(value)) {
                        this.errors[field].push('Email inválido');
                    }
                });
            },
            hasError(field) {
                return this.errors[field] && this.errors[field].length > 0;
            },
            getError(field) {
                return this.errors[field] ? this.errors[field][0] : '';
            }
        })
    }
};

// Event listeners globales
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide alerts después de 5 segundos
    document.querySelectorAll('.alert[data-auto-hide]').forEach(alert => {
        setTimeout(() => {
            alert.style.display = 'none';
        }, 5000);
    });

    // Confirmar acciones destructivas
    document.querySelectorAll('[data-confirm]').forEach(element => {
        element.addEventListener('click', function(e) {
            const message = this.getAttribute('data-confirm');
            if (!confirm(message)) {
                e.preventDefault();
            }
        });
    });

    // Auto-format phone inputs
    document.querySelectorAll('input[type="tel"]').forEach(input => {
        input.addEventListener('input', function() {
            this.value = App.utils.formatPhone(this.value);
        });
    });
});

// Exportar para uso global
window.AppUtils = App.utils;
window.AppComponents = App.components;

console.log('✅ Sistema Base - JavaScript cargado correctamente');