<?php if (isset($component)) { $__componentOriginal58498e54aa219fa993c439a2a6a862f5 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal58498e54aa219fa993c439a2a6a862f5 = $attributes; } ?>
<?php $component = App\View\Components\Layouts\Student::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.student'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Layouts\Student::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Live Classes
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="space-y-6">
        <!-- Success/Error Messages -->
        <?php if(session('success')): ?>
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <!-- Live Classes Grid -->
        <?php $__empty_1 = true; $__currentLoopData = $liveClasses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                <div class="md:flex">
                    <!-- Class Info -->
                    <div class="flex-1 p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <div class="flex items-center space-x-2 mb-2">
                                    <?php if($class->status === 'live'): ?>
                                        <span class="flex items-center px-3 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">
                                            <span class="w-2 h-2 bg-red-500 rounded-full mr-2 animate-pulse"></span>
                                            LIVE NOW
                                        </span>
                                    <?php else: ?>
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">
                                            Scheduled
                                        </span>
                                    <?php endif; ?>
                                    <span class="px-3 py-1 
                                        <?php if($class->mode === 'online'): ?> bg-blue-100 text-blue-800
                                        <?php elseif($class->mode === 'offline'): ?> bg-gray-100 text-gray-800
                                        <?php else: ?> bg-purple-100 text-purple-800 <?php endif; ?>
                                        rounded-full text-xs font-semibold">
                                        <?php echo e(ucfirst($class->mode)); ?>

                                    </span>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 mb-2"><?php echo e($class->topic); ?></h3>
                                <?php if($class->description): ?>
                                    <p class="text-gray-600 text-sm mb-3"><?php echo e($class->description); ?></p>
                                <?php endif; ?>
                            </div>
                        </div>

                        <!-- Meta Information -->
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                <span><?php echo e($class->course->title ?? 'General Session'); ?></span>
                            </div>

                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <span><?php echo e($class->start_datetime->format('M d, Y')); ?></span>
                            </div>

                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span><?php echo e($class->start_datetime->format('h:i A')); ?></span>
                            </div>

                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span><?php echo e($class->duration); ?> mins</span>
                            </div>
                        </div>

                        <!-- Instructor Info -->
                        <div class="flex items-center space-x-3 mb-4 p-3 bg-gray-50 rounded-lg">
                            <img src="<?php echo e($class->instructor->profile_photo_url ?? asset('img/default-avatar.png')); ?>" 
                                 alt="<?php echo e($class->instructor->name); ?>" 
                                 class="w-10 h-10 rounded-full">
                            <div>
                                <p class="text-sm font-medium text-gray-900"><?php echo e($class->instructor->name); ?></p>
                                <p class="text-xs text-gray-500">Instructor</p>
                            </div>
                        </div>

                        <!-- Features -->
                        <div class="flex items-center space-x-4 text-xs text-gray-600">
                            <?php if($class->allow_chat): ?>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Chat
                                </span>
                            <?php endif; ?>
                            <?php if($class->allow_mic): ?>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Microphone
                                </span>
                            <?php endif; ?>
                            <?php if($class->allow_video): ?>
                                <span class="flex items-center">
                                    <svg class="w-4 h-4 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Video
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Join Button Section -->
                    <div class="md:w-64 bg-gray-50 p-6 flex items-center justify-center border-t md:border-t-0 md:border-l border-gray-200">
                        <div class="text-center w-full">
                            <?php if($class->status === 'live'): ?>
                                <a href="<?php echo e(route('student.live-classes.join', $class->id)); ?>" 
                                   class="block w-full px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition font-semibold shadow-lg">
                                    <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    Join Now
                                </a>
                                <p class="text-xs text-gray-500 mt-2">Class is live</p>
                            <?php elseif(now()->greaterThanOrEqualTo($class->start_datetime->copy()->startOfDay())): ?>
                                <a href="<?php echo e(route('student.live-classes.join', $class->id)); ?>" 
                                   class="block w-full px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition font-semibold">
                                    <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    Join Class
                                </a>
                                <p class="text-xs text-gray-500 mt-2">Scheduled for <?php echo e($class->start_datetime->format('h:i A')); ?></p>
                            <?php else: ?>
                                <button disabled 
                                        class="block w-full px-6 py-3 bg-gray-300 text-gray-500 rounded-lg cursor-not-allowed font-semibold">
                                    <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    Not Yet Available
                                </button>
                                <p class="text-xs text-gray-500 mt-2">
                                    Available on <?php echo e($class->start_datetime->format('M d, Y')); ?>

                                </p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Live Classes Available</h3>
                <p class="text-gray-600">There are no scheduled live classes at the moment.</p>
                <p class="text-sm text-gray-500 mt-2">Check back later or browse available courses.</p>
            </div>
        <?php endif; ?>

        <!-- Pagination -->
        <?php if($liveClasses->hasPages()): ?>
            <div class="bg-white rounded-lg shadow p-4">
                <?php echo e($liveClasses->links()); ?>

            </div>
        <?php endif; ?>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal58498e54aa219fa993c439a2a6a862f5)): ?>
<?php $attributes = $__attributesOriginal58498e54aa219fa993c439a2a6a862f5; ?>
<?php unset($__attributesOriginal58498e54aa219fa993c439a2a6a862f5); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal58498e54aa219fa993c439a2a6a862f5)): ?>
<?php $component = $__componentOriginal58498e54aa219fa993c439a2a6a862f5; ?>
<?php unset($__componentOriginal58498e54aa219fa993c439a2a6a862f5); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\paathshaala\resources\views/student/live-classes/index.blade.php ENDPATH**/ ?>