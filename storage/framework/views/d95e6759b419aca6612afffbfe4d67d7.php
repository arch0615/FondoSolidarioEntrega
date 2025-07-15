<?php if($paginator->hasPages()): ?>
    <nav role="navigation" aria-label="<?php echo e(__('Pagination Navigation')); ?>" class="flex items-center justify-center">
        <div class="flex justify-between flex-1 sm:hidden">
            <?php if($paginator->onFirstPage()): ?>
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-secondary-500 bg-white border border-secondary-300 cursor-default leading-5 rounded-md">
                    Anterior
                </span>
            <?php else: ?>
                <a href="<?php echo e($paginator->previousPageUrl()); ?>" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-secondary-700 bg-white border border-secondary-300 leading-5 rounded-md hover:text-secondary-500 focus:outline-none focus:ring ring-secondary-300 focus:border-primary-300 active:bg-secondary-100 active:text-secondary-700 transition ease-in-out duration-150">
                    Anterior
                </a>
            <?php endif; ?>

            <?php if($paginator->hasMorePages()): ?>
                <a href="<?php echo e($paginator->nextPageUrl()); ?>" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-secondary-700 bg-white border border-secondary-300 leading-5 rounded-md hover:text-secondary-500 focus:outline-none focus:ring ring-secondary-300 focus:border-primary-300 active:bg-secondary-100 active:text-secondary-700 transition ease-in-out duration-150">
                    Siguiente
                </a>
            <?php else: ?>
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-secondary-500 bg-white border border-secondary-300 cursor-default leading-5 rounded-md">
                    Siguiente
                </span>
            <?php endif; ?>
        </div>

        <!-- Solo los controles de navegación, sin el texto de información -->
        <div class="hidden sm:flex sm:items-center sm:justify-center">
            <span class="relative z-0 inline-flex rtl:flex-row-reverse shadow-sm rounded-md">
                
                <?php if($paginator->onFirstPage()): ?>
                    <span aria-disabled="true" aria-label="Anterior">
                        <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-secondary-500 bg-white border border-secondary-300 cursor-default rounded-l-md leading-5" aria-hidden="true">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </span>
                <?php else: ?>
                    <a href="<?php echo e($paginator->previousPageUrl()); ?>" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-secondary-500 bg-white border border-secondary-300 rounded-l-md leading-5 hover:text-secondary-400 focus:z-10 focus:outline-none focus:ring ring-secondary-300 focus:border-primary-300 active:bg-secondary-100 active:text-secondary-500 transition ease-in-out duration-150" aria-label="Anterior">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                <?php endif; ?>

                
                <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php if(is_string($element)): ?>
                        <span aria-disabled="true">
                            <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-secondary-700 bg-white border border-secondary-300 cursor-default leading-5"><?php echo e($element); ?></span>
                        </span>
                    <?php endif; ?>

                    
                    <?php if(is_array($element)): ?>
                        <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($page == $paginator->currentPage()): ?>
                                <span aria-current="page">
                                    <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-white bg-primary-600 border border-primary-600 cursor-default leading-5"><?php echo e($page); ?></span>
                                </span>
                            <?php else: ?>
                                <a href="<?php echo e($url); ?>" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-secondary-700 bg-white border border-secondary-300 leading-5 hover:text-secondary-500 focus:z-10 focus:outline-none focus:ring ring-secondary-300 focus:border-primary-300 active:bg-secondary-100 active:text-secondary-700 transition ease-in-out duration-150" aria-label="Ir a la página <?php echo e($page); ?>">
                                    <?php echo e($page); ?>

                                </a>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                
                <?php if($paginator->hasMorePages()): ?>
                    <a href="<?php echo e($paginator->nextPageUrl()); ?>" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-secondary-500 bg-white border border-secondary-300 rounded-r-md leading-5 hover:text-secondary-400 focus:z-10 focus:outline-none focus:ring ring-secondary-300 focus:border-primary-300 active:bg-secondary-100 active:text-secondary-500 transition ease-in-out duration-150" aria-label="Siguiente">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                <?php else: ?>
                    <span aria-disabled="true" aria-label="Siguiente">
                        <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-secondary-500 bg-white border border-secondary-300 cursor-default rounded-r-md leading-5" aria-hidden="true">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </span>
                    </span>
                <?php endif; ?>
            </span>
        </div>
    </nav>
<?php endif; ?><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\vendor\pagination\custom-tailwind.blade.php ENDPATH**/ ?>