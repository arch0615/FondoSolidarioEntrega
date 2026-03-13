<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Fondo Solidario')); ?> - <?php echo e($title ?? 'Dashboard'); ?></title>

    <!-- Scripts -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
     
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    
    
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::styles(); ?>

</head>
<body class="bg-gray-50 min-h-screen font-sans antialiased">
    <!-- Top Navigation Bar -->
    <nav class="bg-white border-b border-gray-200 shadow-sm">
        <div class="px-6 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo and Title -->
                <div class="flex items-center gap-4">
                    <img src="<?php echo e(asset('images/LogoFondoBlanco.png')); ?>" alt="JAEC Logo" class="h-10 object-contain">
                    <div>
                        <h1 class="text-xl font-semibold text-primary-600">Fondo Solidario</h1>
                        <p class="text-sm text-gray-600">Sistema de Gestión JAEC</p>
                    </div>
                </div>

                <!-- User Actions -->
                <div class="flex items-center gap-4">
                    <!-- Notifications -->
                    <?php
$__split = function ($name, $params = []) {
    return [$name, $params];
};
[$__name, $__params] = $__split('notification-bell');

$__html = app('livewire')->mount($__name, $__params, 'lw-2537591576-0', $__slots ?? [], get_defined_vars());

echo $__html;

unset($__html);
unset($__name);
unset($__params);
unset($__split);
if (isset($__slots)) unset($__slots);
?>

                    <!-- User Menu -->
                    <div class="relative">
                        <button onclick="toggleUserMenu()" class="flex items-center gap-2 p-2 text-gray-600 hover:text-primary-600 hover:bg-primary-50 rounded-lg transition-colors">
                            <i class="fas fa-user-circle text-lg"></i>
                            <span class="text-sm font-medium"><?php echo e(Auth::user()->nombre_completo ?? 'Mi Cuenta'); ?></span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        
                        <!-- User Dropdown -->
                        <div id="userDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg z-50">
                            <div class="p-3 border-b border-gray-200">
                                <p class="text-sm font-medium text-gray-900"><?php echo e(Auth::user()->nombre_completo ?? 'Usuario'); ?></p>
                                <p class="text-xs text-gray-600"><?php echo e(Auth::user()->email ?? 'usuario@example.com'); ?></p>
                                <?php if(Auth::user()): ?>
                                    <p class="text-xs text-primary-600 font-medium"><?php echo e(Auth::user()->rol_nombre); ?></p>
                                <?php endif; ?>
                            </div>
                            <div class="py-1">
                                <?php
                                    $user = Auth::user();
                                    $userRole = $user->rol ?? null;
                                    $profileRoute = '#';
                                    
                                    if ($userRole === 'usuario_general') {
                                        $profileRoute = route('perfil.escuela');
                                    } elseif (in_array($userRole, ['admin', 'medico_auditor'])) {
                                        $profileRoute = route('perfil.usuario');
                                    }
                                ?>
                                <a href="<?php echo e($profileRoute); ?>" class="flex items-center gap-2 px-3 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                    <i class="fas fa-user"></i>
                                    Mi Perfil
                                </a>
                                <hr class="my-1">
                                <form method="POST" action="<?php echo e(route('logout')); ?>" class="inline w-full">
                                    <?php echo csrf_field(); ?>
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
            <?php echo $__env->make('layouts.partials.sidebar-navigation', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        </div>

        <!-- Main Content -->
        <main class="flex-1 p-6">
            <!-- Page Header -->
            <?php if (! empty(trim($__env->yieldContent('header')))): ?>
                <div class="mb-6">
                    <?php echo $__env->yieldContent('header'); ?>
                </div>
            <?php endif; ?>

            <!-- Page Content -->
            <?php if(isset($slot)): ?>
                <?php echo e($slot); ?>

            <?php else: ?>
                <?php echo $__env->yieldContent('content'); ?>
            <?php endif; ?>
        </main>
    </div>

    <!-- JavaScript Variables -->
    <script>
        window.userRole = '<?php echo e(Auth::user()->rol ?? "usuario_general"); ?>';
    </script>
    
    <!-- JavaScript -->
    <script>
        function toggleMenu(menuId) {
            const menu = document.getElementById(menuId + '-menu');
            const icon = document.getElementById(menuId + '-icon');

            if (menu) {
                if (menu.classList.contains('hidden')) {
                    menu.classList.remove('hidden');
                    if (icon) icon.className = 'fas fa-chevron-down text-xs';
                } else {
                    menu.classList.add('hidden');
                    if (icon) icon.className = 'fas fa-chevron-right text-xs';
                }
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
                const notificationsDropdown = document.getElementById('notificationsDropdown');
                const userDropdown = document.getElementById('userDropdown');
                if (notificationsDropdown) {
                    notificationsDropdown.classList.add('hidden');
                }
                if (userDropdown) {
                    userDropdown.classList.add('hidden');
                }
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
    
    <?php echo \Livewire\Mechanisms\FrontendAssets\FrontendAssets::scripts(); ?>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views/layouts/app.blade.php ENDPATH**/ ?>