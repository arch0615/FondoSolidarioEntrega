<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Fondo Solidario') }} - {{ $title ?? 'Dashboard' }}</title>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}} {{-- ESTA LÍNEA DEBE SER ELIMINADA O COMENTADA --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    {{-- El bloque tailwind.config se elimina ya que Tailwind CSS ahora se procesa a través de Vite
         y su configuración se encuentra en tailwind.config.js.
         Los colores personalizados 'primary' y 'secondary' definidos aquí
         deberían migrarse a tailwind.config.js si son los deseados.
         Actualmente tailwind.config.js tiene otros valores para primary y secondary.
    --}}
    
    @livewireStyles
</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased">
    <!-- Top Navigation Bar -->
    <nav class="bg-white border-b border-gray-200 shadow-sm">
        <div class="px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo and Title -->
                <div class="flex items-center gap-4">
                    <img src="https://hebbkx1anhila5yf.public.blob.vercel-storage.com/LogoFondoBlanco-oKKkrA6edv1XnSs9HXshtlyWLdv9nx.png" alt="JAEC Logo" class="h-10 object-contain">
                    <div>
                        <h1 class="text-xl font-semibold text-primary-600">Fondo Solidario</h1>
                        <p class="text-sm text-gray-600">Sistema de Gestión JAEC</p>
                    </div>
                </div>

                <!-- User Actions -->
                <div class="flex items-center gap-4">
                    <!-- Notifications -->
                    <div class="relative">
                        <button onclick="toggleNotifications()" class="p-2 text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">
                            <i class="fas fa-bell text-lg"></i>
                            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                        </button>
                        
                        <!-- Notifications Dropdown -->
                        <div id="notificationsDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                            <div class="p-4 border-b border-gray-200">
                                <h3 class="font-semibold text-gray-900">Notificaciones</h3>
                            </div>
                            <div class="max-h-64 overflow-y-auto">
                                <!-- Placeholder notifications -->
                                <div class="p-3 border-b border-gray-100 hover:bg-gray-50">
                                    <p class="text-sm font-medium text-gray-900">Reintegro pendiente</p>
                                    <p class="text-xs text-gray-600">Caso #148 requiere documentación</p>
                                    <p class="text-xs text-gray-500 mt-1">Hace 2 horas</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- User Menu -->
                    <div class="relative">
                        <button onclick="toggleUserMenu()" class="flex items-center gap-2 p-2 text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">
                            <i class="fas fa-user-circle text-lg"></i>
                            <span class="text-sm font-medium">{{ Auth::user()->nombre_completo ?? 'Mi Cuenta' }}</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <!-- User Dropdown -->
                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                            <div class="p-3 border-b border-gray-200">
                                <p class="text-sm font-medium text-gray-900">{{ Auth::user()->nombre_completo ?? 'Usuario' }}</p>
                                <p class="text-xs text-gray-600">{{ Auth::user()->email ?? 'usuario@example.com' }}</p>
                                @if(Auth::user())
                                    <p class="text-xs text-primary-600 font-medium">{{ Auth::user()->rol_nombre }}</p>
                                @endif
                            </div>
                            <div class="py-1">
                                <a href="#" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-user"></i>
                                    Mi Perfil
                                </a>
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}" class="inline w-full">
                                    @csrf
                                    <button type="submit" onclick="return confirm('¿Está seguro que desea cerrar sesión?')" class="flex items-center gap-2 w-full px-3 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <i class="fas fa-sign-out-alt"></i>
                                        Cerrar Sesión
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div class="flex">
        <!-- Sidebar -->
        <div class="w-64 bg-white border-r border-gray-200 min-h-screen">
            @include('layouts.partials.sidebar-navigation')
        </div>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <!-- Page Header -->
            @hasSection('header')
                <div class="mb-6">
                    @yield('header')
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </main>
    </div>

    <!-- JavaScript Variables -->
    <script>
        window.userRole = '{{ Auth::user()->rol ?? "usuario_general" }}';
    </script>
    
    <!-- JavaScript -->
    <script>
        function toggleMenu(menuId) {
            const menu = document.getElementById(menuId + '-menu');
            const icon = document.getElementById(menuId + '-icon');
            
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                icon.className = 'fas fa-chevron-down text-xs';
            } else {
                menu.classList.add('hidden');
                icon.className = 'fas fa-chevron-right text-xs';
            }
        }

        function toggleNotifications() {
            const dropdown = document.getElementById('notificationsDropdown');
            dropdown.classList.toggle('hidden');
            
            // Close user dropdown if open
            document.getElementById('userDropdown').classList.add('hidden');
        }

        function toggleUserMenu() {
            const dropdown = document.getElementById('userDropdown');
            dropdown.classList.toggle('hidden');
            
            // Close notifications dropdown if open
            document.getElementById('notificationsDropdown').classList.add('hidden');
        }

        // Close dropdowns when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.relative')) {
                document.getElementById('notificationsDropdown').classList.add('hidden');
                document.getElementById('userDropdown').classList.add('hidden');
            }
        });

        // Initialize with appropriate menu open based on role
        document.addEventListener('DOMContentLoaded', function() {
            if (window.userRole === 'usuario_general') {
                const accidentesMenu = document.getElementById('accidentes-menu');
                if (accidentesMenu) {
                    accidentesMenu.classList.remove('hidden');
                }
            }
        });
    </script>
    
    @livewireScripts
    @stack('scripts')
</body>
</html>