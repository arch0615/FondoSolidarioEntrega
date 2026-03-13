<div class="relative" x-data="{ open: false }" @click.away="open = false">
    <button @click="open = !open; if(open) { $wire.loadNotifications(); $wire.markAsRead(); }" class="relative p-2 text-gray-500 rounded-full hover:bg-gray-100 hover:text-gray-600 focus:bg-gray-100 focus:text-gray-600">
        <i class="fas fa-bell"></i>
        <!--[if BLOCK]><![endif]--><?php if($unreadNotificationsCount > 0): ?>
            <span class="absolute top-0 right-0 flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full">
                <?php echo e($unreadNotificationsCount); ?>

            </span>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </button>

    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 w-80 mt-2 origin-top-right bg-white rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
         style="display: none;">
        <div class="py-1">
            <div class="px-4 py-2 text-sm text-gray-700 font-semibold border-b">Notificaciones</div>
            <div class="divide-y divide-gray-100">
                <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div wire:click="redirectToNotification(<?php echo e($notification->id_notificacion); ?>)" class="block px-4 py-3 text-sm text-gray-700 hover:bg-gray-100 cursor-pointer transition-colors duration-200">
                        <p class="font-bold"><?php echo e($notification->titulo); ?></p>
                        <p class="text-xs text-gray-500"><?php echo e($notification->mensaje); ?></p>
                        <p class="text-xs text-gray-400 mt-1"><?php echo e($notification->fecha_creacion->diffForHumans()); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="px-4 py-3 text-sm text-gray-500 text-center">No hay notificaciones nuevas.</div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    </div>
</div><?php /**PATH /home/passion/Documents/FondoSolidarioEntrega11/Fondo Solidario Entrega/resources/views/livewire/notification-bell.blade.php ENDPATH**/ ?>