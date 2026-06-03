<?php if (isset($component)) { $__componentOriginal23a33f287873b564aaf305a1526eada4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal23a33f287873b564aaf305a1526eada4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layout','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="space-y-6">
        <h2 class="text-2xl font-bold text-slate-900">Weekly Schedule</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-7 gap-4">
            <?php $__currentLoopData = range(0, 6); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $date = now()->addDays($i)->format('Y-m-d'); ?>
                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm min-h-[200px]">
                    <h3 class="font-bold text-xs text-slate-500 mb-4 uppercase text-center">
                        <?php echo e(now()->addDays($i)->format('D, M d')); ?>

                    </h3>
                    
                    <div class="space-y-2">
                        <?php $__empty_1 = true; $__currentLoopData = $appointments->get($date, []); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $appt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <div class="p-2 bg-blue-50 border border-blue-100 rounded-lg">
                                <p class="text-[10px] font-bold text-blue-900 truncate"><?php echo e($appt->user->name); ?></p>
                                <p class="text-[9px] text-blue-600"><?php echo e($appt->service->name); ?></p>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <div class="text-center py-4">
                                <p class="text-[10px] text-slate-300 italic">No sessions</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $attributes = $__attributesOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__attributesOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal23a33f287873b564aaf305a1526eada4)): ?>
<?php $component = $__componentOriginal23a33f287873b564aaf305a1526eada4; ?>
<?php unset($__componentOriginal23a33f287873b564aaf305a1526eada4); ?>
<?php endif; ?><?php /**PATH C:\xampp\htdocs\appointment-system\resources\views/admin/calendar.blade.php ENDPATH**/ ?>