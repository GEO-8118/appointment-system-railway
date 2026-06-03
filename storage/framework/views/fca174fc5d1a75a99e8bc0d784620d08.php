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
     <?php $__env->slot('nav', null, []); ?> 
        <?php if (isset($component)) { $__componentOriginalc295f12dca9d42f28a259237a5724830 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc295f12dca9d42f28a259237a5724830 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.nav-link','data' => ['href' => '/dashboard','active' => 'true']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('nav-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => '/dashboard','active' => 'true']); ?>Admin Dashboard Control <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $attributes = $__attributesOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__attributesOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc295f12dca9d42f28a259237a5724830)): ?>
<?php $component = $__componentOriginalc295f12dca9d42f28a259237a5724830; ?>
<?php unset($__componentOriginalc295f12dca9d42f28a259237a5724830); ?>
<?php endif; ?>
     <?php $__env->endSlot(); ?>

    <div class="md:flex md:items-center md:justify-between mb-8 space-y-4 md:space-y-0">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900">Admin Controls</h1>
            <p class="text-slate-500 mt-1">
                Review user appointments and manage system catalog metadata configurations.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-3">
            <a href="<?php echo e(route('reports.exportJson')); ?>"
               class="inline-flex items-center bg-white hover:bg-slate-50 text-slate-700 border border-slate-300 font-medium px-4 py-2 rounded-xl text-sm shadow-sm transition">
                📥 Export Appointment JSON
            </a>

            <form action="<?php echo e(route('services.importCsv')); ?>"
                  method="POST"
                  enctype="multipart/form-data"
                  class="flex items-center bg-white border border-slate-300 p-1.5 rounded-xl shadow-sm">
                <?php echo csrf_field(); ?>

                <input type="file"
                       name="csv_file"
                       required
                       class="text-xs text-slate-500 file:mr-3 file:py-1 file:px-2 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 cursor-pointer w-44">

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-2.5 py-1 rounded-lg transition">
                    Import Services
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white shadow-sm border border-slate-200 rounded-2xl overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50 border-b border-slate-200 text-xs uppercase font-bold text-slate-500">
                    <th class="p-4">Customer Info</th>
                    <th class="p-4">Requested Service</th>
                    <th class="p-4">Scheduled Window</th>
                    <th class="p-4">Status</th>
                    <th class="p-4 text-right">Administrative Actions</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-slate-100 text-sm">
                <?php $__empty_1 = true; $__currentLoopData = $appointments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-slate-50 transition">

                        <td class="p-4 font-semibold text-slate-900">
                            <?php echo e($app->user->name); ?>

                            <span class="block text-xs text-slate-400 font-normal">
                                <?php echo e($app->user->email); ?>

                            </span>
                        </td>

                        <td class="p-4 text-slate-700">
                            <?php echo e($app->services->isNotEmpty() ? $app->services->pluck('name')->join(', ') : $app->service->name); ?>

                        </td>

                        <td class="p-4 text-slate-600 font-medium">
                            <?php echo e($app->schedule->available_date); ?>

                            <span class="block text-xs text-slate-400 font-normal">
                                <?php echo e($app->schedule->start_time); ?> - <?php echo e($app->schedule->end_time); ?>

                            </span>
                        </td>

                        <td class="p-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                                <?php echo e($app->status === 'approved'
                                    ? 'bg-emerald-50 text-emerald-700'
                                    : ($app->status === 'rejected'
                                        ? 'bg-rose-50 text-rose-700'
                                        : 'bg-amber-50 text-amber-700')); ?>">
                                <?php echo e(ucfirst($app->status)); ?>

                            </span>
                        </td>

                        <td class="p-4 text-right space-x-2 whitespace-nowrap">

                            <?php if($app->status === 'pending'): ?>

                                <form action="<?php echo e(route('appointments.status', $app->id)); ?>"
                                      method="POST"
                                      class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>

                                    <input type="hidden"
                                           name="status"
                                           value="approved">

                                    <button class="bg-emerald-600 text-white text-xs font-semibold px-2.5 py-1.5 rounded-lg">
                                        Approve
                                    </button>
                                </form>

                                <form action="<?php echo e(route('appointments.status', $app->id)); ?>"
                                      method="POST"
                                      class="inline">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>

                                    <input type="hidden"
                                           name="status"
                                           value="rejected">

                                    <button class="bg-slate-600 text-white text-xs font-semibold px-2.5 py-1.5 rounded-lg">
                                        Reject
                                    </button>
                                </form>

                            <?php endif; ?>

                            <form action="<?php echo e(route('appointments.destroy', $app->id)); ?>"
                                  method="POST"
                                  class="inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>

                                <button class="text-rose-600 text-xs font-bold px-2 py-1.5">
                                    Delete
                                </button>
                            </form>

                        </td>

                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="5" class="p-8 text-center text-slate-400">
                            No system records available.
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
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
<?php endif; ?><?php /**PATH C:\xampp\htdocs\appointment-system\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>