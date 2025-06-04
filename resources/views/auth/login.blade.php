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
                    <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/LogoFondoBlanco-oKKkrA6edv1XnSs9HXshtlyWLdv9nx.png" alt="JAEC Logo" class="h-20 object-contain">
                </div>
            </div>

            <!-- Login Card -->
            <div class="bg-white border border-gray-200 rounded-lg shadow-lg p-8">
                <div class="text-center mb-6">
                    <h1 class="text-3xl font-bold text-primary-600 mb-2">Fondo Solidario</h1>
                    <p class="text-secondary-600 font-medium">Sistema de Gestión JAEC</p>
                </div>

                <!-- Mensajes de error -->
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center gap-2 text-red-800">
                            <i class="fas fa-exclamation-circle"></i>
                            <span class="font-medium">Error de autenticación</span>
                        </div>
                        <ul class="mt-2 text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Mensaje de éxito -->
                @if (session('status'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center gap-2 text-green-800">
                            <i class="fas fa-check-circle"></i>
                            <span class="text-sm">{{ session('status') }}</span>
                        </div>
                    </div>
                @endif

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
                        <div class="flex items-center">
                            <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-primary-600 focus:ring-primary-500 border-gray-300 rounded" {{ old('remember') ? 'checked' : '' }}>
                            <label for="remember" class="ml-2 text-sm text-gray-600">Recordarme</label>
                        </div>
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

            <!-- Footer Logos -->
            <div class="flex justify-center items-center gap-8 mt-8 opacity-70">
                <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/ArquidiocesisCordobaFondoBlanco-ZmRySIfLI0v5ZoSOU85SCxceAqop4c.png" alt="Arquidiócesis de Córdoba" class="h-10 object-contain">
                <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/EducaresAmar-t3yKamJPDToIMZzgXzmnMYdL9IeY2Q.png" alt="Educar es Amar" class="h-12 object-contain">
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

    <script>
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