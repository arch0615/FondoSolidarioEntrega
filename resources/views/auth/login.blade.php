<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Fondo Solidario - Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f0f9f4',
                            100: '#dcf2e4',
                            200: '#bce5cd',
                            300: '#8dd1ab',
                            400: '#57b582',
                            500: '#339966',
                            600: '#2a7d54',
                            700: '#236446',
                            800: '#1e5038',
                            900: '#1a4230'
                        },
                        secondary: {
                            50: '#f0f9ff',
                            100: '#e0f2fe',
                            200: '#bae6fd',
                            300: '#7dd3fc',
                            400: '#38bdf8',
                            500: '#0ea5e9',
                            600: '#0284c7',
                            700: '#0369a1',
                            800: '#075985',
                            900: '#0c4a6e'
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen bg-white">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md">
            <!-- Logo Section -->
            <div class="text-center mb-8">
                <div class="flex justify-center items-center gap-4 mb-6">
                    <img src="{{ asset('images/LogoFondoBlanco.png') }}" alt="JAEC Logo" class="h-20 object-contain">
                </div>
            </div>

            <!-- Login Card -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-lg p-8">
                <div class="text-center mb-6">
                    <h1 class="text-3xl font-bold text-primary-600 mb-2">Fondo Solidario</h1>
                    <p class="text-secondary-600 font-medium">Sistema de Gestión JAEC</p>
                </div>

                {{-- Errors and status are shown as toasts (see script below) --}}

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    
                    <div class="space-y-2">
                        <label for="email" class="block text-sm font-medium text-gray-700">Correo Electrónico</label>
                        <div class="relative">
                            <i class="fas fa-envelope absolute left-3 top-3 text-primary-500"></i>
                            <input 
                                type="email" 
                                id="email" 
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="usuario@escuela.edu.ar"
                                class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:border-primary-500 focus:ring-2 focus:ring-primary-200 focus:outline-none transition-colors @error('email') border-red-500 @enderror"
                                required
                                autofocus
                            >
                        </div>
                        @error('email')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-2">
                        <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                        <div class="relative">
                            <i class="fas fa-lock absolute left-3 top-3 text-primary-500"></i>
                            <input 
                                type="password" 
                                id="password" 
                                name="password"
                                placeholder="••••••••"
                                class="w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:border-primary-500 focus:ring-2 focus:ring-primary-200 focus:outline-none transition-colors @error('password') border-red-500 @enderror"
                                required
                            >
                            <button type="button" onclick="togglePassword()" class="absolute right-3 top-3 text-gray-400 hover:text-gray-600">
                                <i id="passwordIcon" class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        <div></div>
                        <button type="button" onclick="openResetModal()" class="text-sm text-primary-600 hover:text-primary-700 font-medium">
                            ¿Olvidó su contraseña?
                        </button>
                    </div>

                    <button 
                        type="submit" 
                        class="w-full py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg shadow-sm transition-colors duration-200"
                        id="loginButton"
                    >
                        <span id="loginText">Iniciar Sesión</span>
                        <span id="loginLoading" class="hidden">
                            <i class="fas fa-spinner fa-spin mr-2"></i>Iniciando sesión...
                        </span>
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-xs text-gray-500">Sistema seguro protegido por JAEC</p>
                </div>
            </div>

            <!-- Test Credentials Panel -->
            @if(config('app.env') === 'local')
            <div class="mt-6 border border-dashed border-gray-300 rounded-lg p-4 bg-gray-50">
                <div class="flex items-center gap-2 mb-3">
                    <i class="fas fa-flask text-xs text-gray-400"></i>
                    <span class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Credenciales de prueba</span>
                </div>
                <div class="grid grid-cols-1 gap-2">
                    <button type="button" onclick="fillCredentials('admin@prueba.com', 'password')"
                        class="flex items-center gap-3 w-full p-2.5 rounded-lg border border-gray-200 bg-white hover:border-primary-400 hover:bg-primary-50 transition-colors text-left group">
                        <span class="flex-shrink-0 w-8 h-8 rounded-full bg-purple-100 flex items-center justify-center">
                            <i class="fas fa-user-shield text-xs text-purple-600"></i>
                        </span>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-gray-800">Administrador</p>
                            <p class="text-xs text-gray-500 truncate">admin@prueba.com</p>
                        </div>
                        <i class="fas fa-arrow-right text-xs text-gray-300 group-hover:text-primary-500 transition-colors"></i>
                    </button>

                    <button type="button" onclick="fillCredentials('medico@prueba.com', 'password')"
                        class="flex items-center gap-3 w-full p-2.5 rounded-lg border border-gray-200 bg-white hover:border-blue-400 hover:bg-blue-50 transition-colors text-left group">
                        <span class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                            <i class="fas fa-user-md text-xs text-blue-600"></i>
                        </span>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-gray-800">Médico Auditor</p>
                            <p class="text-xs text-gray-500 truncate">medico@prueba.com</p>
                        </div>
                        <i class="fas fa-arrow-right text-xs text-gray-300 group-hover:text-blue-500 transition-colors"></i>
                    </button>

                    <button type="button" onclick="fillCredentials('user@prueba.com', 'password')"
                        class="flex items-center gap-3 w-full p-2.5 rounded-lg border border-gray-200 bg-white hover:border-green-400 hover:bg-green-50 transition-colors text-left group">
                        <span class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                            <i class="fas fa-school text-xs text-green-600"></i>
                        </span>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-gray-800">Usuario General — Escuela 1</p>
                            <p class="text-xs text-gray-500 truncate">user@prueba.com</p>
                        </div>
                        <i class="fas fa-arrow-right text-xs text-gray-300 group-hover:text-green-500 transition-colors"></i>
                    </button>

                    <button type="button" onclick="fillCredentials('test@prueba.com', 'password')"
                        class="flex items-center gap-3 w-full p-2.5 rounded-lg border border-gray-200 bg-white hover:border-green-400 hover:bg-green-50 transition-colors text-left group">
                        <span class="flex-shrink-0 w-8 h-8 rounded-full bg-green-100 flex items-center justify-center">
                            <i class="fas fa-school text-xs text-green-600"></i>
                        </span>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs font-semibold text-gray-800">Usuario General — Escuela 2</p>
                            <p class="text-xs text-gray-500 truncate">test@prueba.com</p>
                        </div>
                        <i class="fas fa-arrow-right text-xs text-gray-300 group-hover:text-green-500 transition-colors"></i>
                    </button>
                </div>
                <p class="text-xs text-gray-400 mt-3 text-center">
                    <i class="fas fa-lock text-xs mr-1"></i>Contraseña: <span class="font-mono font-medium text-gray-600">password</span>
                    &nbsp;·&nbsp; Solo visible en entorno local
                </p>
            </div>
            @endif

            <!-- Footer Logos -->
            <div class="flex justify-center items-center gap-8 mt-8 opacity-70">
                <img src="{{ asset('images/ArquidiocesisCordobaFondoBlanco.png') }}" alt="Arquidiócesis de Córdoba" class="h-10 object-contain">
                <img src="{{ asset('images/EducaresAmar.png') }}" alt="Educar es Amar" class="h-12 object-contain">
            </div>
        </div>
    </div>

    <!-- Modal de Recuperación de Contraseña -->
    <div id="resetModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4 shadow-xl">
            <div class="flex items-center gap-2 mb-4">
                <i class="fas fa-shield-alt text-primary-600"></i>
                <h3 class="text-lg font-semibold text-gray-900">Recuperar Contraseña</h3>
            </div>
            <p class="text-gray-600 mb-6">Ingrese su correo electrónico y le enviaremos un enlace para restablecer su contraseña.</p>
            
            <form action="{{ route('forgot-password') }}" method="POST" id="resetForm">
                @csrf
                <div class="mb-6">
                    <label for="resetEmail" class="block text-sm font-medium text-gray-700 mb-2">Correo Electrónico</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3 top-3 text-gray-400"></i>
                        <input 
                            type="email" 
                            id="resetEmail" 
                            name="email"
                            placeholder="usuario@escuela.edu.ar"
                            class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:border-primary-500 focus:ring-2 focus:ring-primary-200 focus:outline-none transition-colors"
                            required
                        >
                    </div>
                </div>
                
                <div class="flex gap-3">
                    <button type="button" onclick="closeResetModal()" class="flex-1 py-2 px-4 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" class="flex-1 py-2 px-4 bg-primary-600 hover:bg-primary-700 text-white rounded-lg transition-colors">
                        <span id="resetText">Enviar Enlace</span>
                        <span id="resetLoading" class="hidden">
                            <i class="fas fa-spinner fa-spin mr-1"></i>Enviando...
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-[9999] flex flex-col gap-2 w-80 pointer-events-none"></div>

    <script>
        function showToast(message, type, duration) {
            duration = duration || 5000;
            var container = document.getElementById('toast-container');
            var styles = { success: 'bg-green-500 text-white', error: 'bg-red-500 text-white', warning: 'bg-yellow-400 text-gray-900', info: 'bg-blue-500 text-white' };
            var paths = {
                success: '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>',
                error:   '<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>',
                warning: '<path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>',
                info:    '<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>',
            };
            var toast = document.createElement('div');
            toast.className = 'pointer-events-auto flex items-start gap-3 p-4 rounded-lg shadow-lg ' + (styles[type] || styles.info) + ' translate-x-full opacity-0 transition-all duration-300 ease-out';
            toast.innerHTML = '<svg class="h-5 w-5 flex-shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">' + (paths[type] || paths.info) + '</svg><p class="text-sm font-medium flex-1">' + message + '</p><button class="flex-shrink-0 opacity-75 hover:opacity-100 ml-1"><svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/></svg></button>';
            var dismiss = function() {
                toast.classList.add('translate-x-full', 'opacity-0');
                toast.addEventListener('transitionend', function() { toast.remove(); }, { once: true });
            };
            toast.querySelector('button').addEventListener('click', dismiss);
            container.appendChild(toast);
            requestAnimationFrame(function() { requestAnimationFrame(function() { toast.classList.remove('translate-x-full', 'opacity-0'); }); });
            var timer = setTimeout(dismiss, duration);
            toast.addEventListener('mouseenter', function() { clearTimeout(timer); });
            toast.addEventListener('mouseleave', function() { setTimeout(dismiss, 1500); });
        }

        document.addEventListener('DOMContentLoaded', function () {
            @foreach ($errors->all() as $error)
                showToast(@json($error), 'error');
            @endforeach
            @if (session('toast_error'))
                showToast(@json(session('toast_error')), 'error');
            @endif
            @if (session('status'))
                showToast(@json(session('status')), 'success');
            @endif
        });
    </script>

    <script>
        function fillCredentials(email, password) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
            document.getElementById('email').dispatchEvent(new Event('input'));
            document.getElementById('password').dispatchEvent(new Event('input'));
            showToast('Credenciales cargadas — haga clic en Iniciar Sesión', 'info', 3000);
        }

        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const passwordIcon = document.getElementById('passwordIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                passwordIcon.className = 'fas fa-eye-slash';
            } else {
                passwordInput.type = 'password';
                passwordIcon.className = 'fas fa-eye';
            }
        }

        function openResetModal() {
            document.getElementById('resetModal').classList.remove('hidden');
            document.getElementById('resetModal').classList.add('flex');
        }

        function closeResetModal() {
            document.getElementById('resetModal').classList.add('hidden');
            document.getElementById('resetModal').classList.remove('flex');
            document.getElementById('resetForm').reset();
        }

        // Mostrar loading en el botón de login
        document.querySelector('form').addEventListener('submit', function(e) {
            const loginButton = document.getElementById('loginButton');
            const loginText = document.getElementById('loginText');
            const loginLoading = document.getElementById('loginLoading');
            
            loginText.classList.add('hidden');
            loginLoading.classList.remove('hidden');
            loginButton.disabled = true;
        });

        // Mostrar loading en el formulario de reset
        document.getElementById('resetForm').addEventListener('submit', function(e) {
            const resetText = document.getElementById('resetText');
            const resetLoading = document.getElementById('resetLoading');
            
            resetText.classList.add('hidden');
            resetLoading.classList.remove('hidden');
        });

        // Cerrar modal al hacer clic fuera
        document.getElementById('resetModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeResetModal();
            }
        });
    </script>
</body>
</html>