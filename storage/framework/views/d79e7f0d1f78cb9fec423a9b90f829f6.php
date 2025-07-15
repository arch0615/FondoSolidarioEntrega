<?php if (isset($component)) { $__componentOriginal5863877a5171c196453bfa0bd807e410 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5863877a5171c196453bfa0bd807e410 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.app','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.app'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> 
        Detalle de Auditoría
     <?php $__env->endSlot(); ?>

    <div class="mx-auto px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-semibold text-secondary-900">Detalle del Evento de Auditoría</h1>
            <a href="<?php echo e(route('auditoria.historial-auditorias')); ?>" class="px-4 py-2 bg-secondary-200 text-secondary-800 rounded-lg hover:bg-secondary-300 transition-colors">
                &larr; Volver al Historial
            </a>
        </div>

        <div class="bg-white rounded-xl shadow-2xl w-full">
            <?php if($itemType === 'auditoria'): ?>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-6">
                        <div>
                            <h4 class="font-semibold text-secondary-800 mb-3">Detalles del Evento</h4>
                            <div class="text-sm space-y-2">
                                <div><strong class="text-secondary-600 w-28 inline-block">Fecha:</strong> <?php echo e($item->fecha_hora->format('d/m/Y H:i:s')); ?></div>
                                <div><strong class="text-secondary-600 w-28 inline-block">Usuario:</strong> <?php echo e($item->usuario->email ?? 'N/A'); ?></div>
                                <div><strong class="text-secondary-600 w-28 inline-block">Acción:</strong> <?php echo e($item->accion); ?></div>
                                <div><strong class="text-secondary-600 w-28 inline-block">Tabla:</strong> <?php echo e($item->tabla_afectada); ?></div>
                                <div><strong class="text-secondary-600 w-28 inline-block">ID Registro:</strong> <?php echo e($item->id_registro); ?></div>
                            </div>
                        </div>
                        <div>
                            <h4 class="font-semibold text-secondary-800 mb-3">Información del Reintegro</h4>
                            <div class="text-sm space-y-2">
                                <div><strong class="text-secondary-600 w-28 inline-block">Alumno:</strong> <?php echo e($item->reintegro->accidente->alumnos->first()->alumno->nombre_completo ?? 'N/A'); ?></div>
                                <div><strong class="text-secondary-600 w-28 inline-block">Escuela:</strong> <?php echo e($item->reintegro->accidente->escuela->nombre ?? 'N/A'); ?></div>
                                <div><strong class="text-secondary-600 w-28 inline-block">Monto:</strong> $<?php echo e(number_format($item->reintegro->monto_solicitado, 2)); ?></div>
                            </div>
                        </div>
                    </div>
                    <div class="space-y-6">
                        <div>
                            <h4 class="font-semibold text-secondary-800 mb-2">Datos Anteriores</h4>
                            <pre class="bg-secondary-50 p-3 rounded-lg text-xs text-secondary-700 overflow-x-auto"><?php echo json_encode(json_decode($item->datos_anteriores), JSON_PRETTY_PRINT, 512) ?></pre>
                        </div>
                        <div>
                            <h4 class="font-semibold text-secondary-800 mb-2">Datos Nuevos</h4>
                            <pre class="bg-secondary-50 p-3 rounded-lg text-xs text-secondary-700 overflow-x-auto"><?php echo json_encode(json_decode($item->datos_nuevos), JSON_PRETTY_PRINT, 512) ?></pre>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="p-6 space-y-6">
                    <div>
                        <h4 class="font-semibold text-secondary-800 mb-3">Detalles de la Solicitud</h4>
                        <div class="text-sm space-y-2">
                            <div><strong class="text-secondary-600 w-40 inline-block">Fecha Solicitud:</strong> <?php echo e($item->fecha_solicitud->format('d/m/Y H:i:s')); ?></div>
                            <div><strong class="text-secondary-600 w-40 inline-block">Auditor:</strong> <?php echo e($item->auditor->nombre_completo ?? 'N/A'); ?></div>
                            <div><strong class="text-secondary-600 w-40 inline-block">Estado:</strong> <?php echo e($item->estadoSolicitud->nombre_estado ?? 'N/A'); ?></div>
                            <div><strong class="text-secondary-600 w-40 inline-block">Reintegro ID:</strong> <?php echo e($item->id_reintegro); ?></div>
                        </div>
                    </div>
                    <div>
                        <h4 class="font-semibold text-secondary-800 mb-2">Descripción de la Solicitud</h4>
                        <p class="text-sm text-secondary-700"><?php echo e($item->descripcion_solicitud); ?></p>
                    </div>
                    <div>
                        <h4 class="font-semibold text-secondary-800 mb-2">Documentos Requeridos</h4>
                        <p class="text-sm text-secondary-700"><?php echo e($item->documentos_requeridos); ?></p>
                    </div>
                     <?php if($item->fecha_respuesta): ?>
                    <div>
                        <h4 class="font-semibold text-secondary-800 mb-3">Respuesta</h4>
                         <div class="text-sm space-y-2">
                            <div><strong class="text-secondary-600 w-40 inline-block">Fecha Respuesta:</strong> <?php echo e($item->fecha_respuesta->format('d/m/Y H:i:s')); ?></div>
                            <div><strong class="text-secondary-600 w-40 inline-block">Usuario Respuesta:</strong> <?php echo e($item->usuarioResponde->nombre_completo ?? 'N/A'); ?></div>
                            <div>
                                <strong class="text-secondary-600 w-40 inline-block align-top">Observaciones:</strong>
                                <p class="inline-block w-2/3"><?php echo e($item->observaciones_respuesta); ?></p>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $attributes = $__attributesOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__attributesOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5863877a5171c196453bfa0bd807e410)): ?>
<?php $component = $__componentOriginal5863877a5171c196453bfa0bd807e410; ?>
<?php unset($__componentOriginal5863877a5171c196453bfa0bd807e410); ?>
<?php endif; ?><?php /**PATH C:\Users\rican\OneDrive\Documentos\workana\Fondo Solidario\resources\views\auditoria\detalle.blade.php ENDPATH**/ ?>