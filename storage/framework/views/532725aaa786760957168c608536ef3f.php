<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(config('app.name', 'Sistema Base')); ?></title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="antialiased">
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-gray-100 selection:bg-red-500 selection:text-white">
        <?php if(Route::has('login')): ?>
            <div class="sm:fixed sm:top-0 sm:right-0 p-6 text-right z-10">
                <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(url('/dashboard')); ?>" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline-none focus:rounded-sm focus:ring focus:ring-indigo-200">Dashboard</a>
                <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline-none focus:rounded-sm focus:ring focus:ring-indigo-200">Iniciar Sesión</a>

                    <?php if(Route::has('register')): ?>
                        <a href="<?php echo e(route('register')); ?>" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 focus:outline-none focus:rounded-sm focus:ring focus:ring-indigo-200">Registro</a>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            <div class="flex justify-center">
                <div class="text-center">
                    <div class="flex justify-center">
                        <svg class="w-16 h-16 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zm0 4a1 1 0 011-1h12a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1V8zm2 2a1 1 0 000 2h8a1 1 0 100-2H5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    
                    <h1 class="mt-4 text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">
                        Sistema Base
                    </h1>
                    
                    <p class="mt-6 text-lg leading-8 text-gray-600">
                        Plantilla base para proyectos Laravel + Livewire + MySQL
                    </p>
                    
                    <div class="mt-10 flex items-center justify-center gap-x-6">
                        <a href="/login.html" class="rounded-md bg-blue-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-blue-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-blue-600">
                            Ver Login HTML
                        </a>
                        <a href="<?php echo e(route('login')); ?>" class="text-sm font-semibold leading-6 text-gray-900">
                            Login Laravel <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mt-16">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                    <div class="scale-100 p-6 bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <div class="h-16 w-16 bg-red-50 flex items-center justify-center rounded-lg">
                                <svg class="w-7 h-7 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.293l-3-3a1 1 0 00-1.414 0l-3 3a1 1 0 001.414 1.414L9 9.414V13a1 1 0 102 0V9.414l1.293 1.293a1 1 0 001.414-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>

                            <h2 class="mt-6 text-xl font-semibold text-gray-900">Laravel 11.x</h2>

                            <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                                Framework PHP moderno con todas las características necesarias para desarrollo web robusto y escalable.
                            </p>
                        </div>
                    </div>

                    <div class="scale-100 p-6 bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <div class="h-16 w-16 bg-blue-50 flex items-center justify-center rounded-lg">
                                <svg class="w-7 h-7 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.316 3.051a1 1 0 01.633 1.265l-4 12a1 1 0 11-1.898-.632l4-12a1 1 0 011.265-.633zM5.707 6.293a1 1 0 010 1.414L3.414 10l2.293 2.293a1 1 0 11-1.414 1.414l-3-3a1 1 0 010-1.414l3-3a1 1 0 011.414 0zm8.586 0a1 1 0 011.414 0l3 3a1 1 0 010 1.414l-3 3a1 1 0 11-1.414-1.414L16.586 10l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>

                            <h2 class="mt-6 text-xl font-semibold text-gray-900">Livewire 3.x</h2>

                            <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                                Componentes dinámicos y reactivos sin la complejidad de JavaScript frameworks separados.
                            </p>
                        </div>
                    </div>

                    <div class="scale-100 p-6 bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                        <div>
                            <div class="h-16 w-16 bg-green-50 flex items-center justify-center rounded-lg">
                                <svg class="w-7 h-7 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v3.586l-1.293-1.293a1 1 0 10-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L11 11.586V8z" clip-rule="evenodd" />
                                </svg>
                            </div>

                            <h2 class="mt-6 text-xl font-semibold text-gray-900">Listo para usar</h2>

                            <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                                Estructura completa con login responsivo, CSS moderno y JavaScript optimizado para desarrollo rápido.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-center mt-16 px-0 sm:items-center sm:justify-between">
                <div class="text-center text-sm text-gray-500 sm:text-left">
                    <div class="flex items-center gap-4">
                        <a href="https://laravel.com/docs" class="group inline-flex items-center hover:text-gray-700 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                            Documentación Laravel
                        </a>

                        <a href="https://livewire.laravel.com/docs" class="group inline-flex items-center hover:text-gray-700 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
                            Documentación Livewire
                        </a>
                    </div>
                </div>

                <div class="ml-4 text-center text-sm text-gray-500 sm:text-right sm:ml-0">
                    Laravel v<?php echo e(Illuminate\Foundation\Application::VERSION); ?> (PHP v<?php echo e(PHP_VERSION); ?>)
                </div>
            </div>
        </div>
    </div>
</body>
</html><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\welcome.blade.php ENDPATH**/ ?>