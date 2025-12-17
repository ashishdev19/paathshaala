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
            <?php echo e($course->title); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Course Header -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                <div class="md:flex">
                    <div class="md:flex-shrink-0">
                        <?php if($course->thumbnail): ?>
                            <img class="h-48 w-full object-cover md:w-48" 
                                 src="/storage/<?php echo e($course->thumbnail); ?>" 
                                 alt="<?php echo e($course->title); ?>">
                        <?php else: ?>
                            <div class="h-48 w-full md:w-48 bg-blue-100 flex items-center justify-center">
                                <svg class="w-20 h-20 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="p-8 flex-1">
                        <div class="uppercase tracking-wide text-sm text-indigo-500 font-semibold"><?php echo e($course->category->name ?? 'General'); ?></div>
                        <h1 class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                            <?php echo e($course->title); ?>

                        </h1>
                        <p class="mt-4 text-gray-600"><?php echo e($course->description); ?></p>
                        
                        <div class="mt-6 flex items-center gap-6">
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <?php echo e($course->teacher->name ?? 'N/A'); ?>

                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-2 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                                <?php echo e(number_format($course->reviews_avg_rating ?? 4.5, 1)); ?> (<?php echo e($course->reviews_count ?? 0); ?> reviews)
                            </div>
                            <div class="flex items-center text-sm text-gray-600">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                                <?php echo e($course->enrollments_count ?? 0); ?> students
                            </div>
                        </div>

                        <div class="mt-6 flex items-center gap-4">
                            <div class="text-3xl font-bold text-gray-900">
                                ₹<?php echo e(number_format($course->price, 2)); ?>

                            </div>
                            <?php if(!$isEnrolled): ?>
                                <?php if(auth()->guard()->check()): ?>
                                    <a href="<?php echo e(route('enrollment.checkout', $course->id)); ?>" 
                                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Enroll Now
                                    </a>
                                <?php else: ?>
                                    <a href="<?php echo e(route('login')); ?>" 
                                       class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Login to Enroll
                                    </a>
                                <?php endif; ?>
                            <?php else: ?>
                                <a href="<?php echo e(route('student.courses')); ?>" 
                                   class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Already Enrolled - Go to Course
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Details Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- What you'll learn -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">What you'll learn</h2>
                        <div class="prose max-w-none">
                            <?php echo nl2br(e($course->description)); ?>

                        </div>
                    </div>

                    <!-- Course Content -->
                    <?php if($course->onlineClasses && $course->onlineClasses->count() > 0): ?>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Course Content</h2>
                        <div class="space-y-2">
                            <?php $__currentLoopData = $course->onlineClasses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border border-gray-200 rounded-lg p-4">
                                <h3 class="font-semibold text-gray-900"><?php echo e($class->title); ?></h3>
                                <p class="text-sm text-gray-600 mt-1"><?php echo e($class->description); ?></p>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Reviews -->
                    <?php if($course->reviews && $course->reviews->count() > 0): ?>
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-4">Student Reviews</h2>
                        <div class="space-y-4">
                            <?php $__currentLoopData = $course->reviews->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="border-b border-gray-200 pb-4 last:border-0">
                                <div class="flex items-center mb-2">
                                    <div class="flex text-yellow-400">
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <svg class="w-5 h-5 <?php echo e($i <= $review->rating ? 'fill-current' : 'text-gray-300'); ?>" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="ml-2 text-sm text-gray-600"><?php echo e($review->user->name ?? 'Student'); ?></span>
                                </div>
                                <p class="text-gray-700"><?php echo e($review->comment); ?></p>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Instructor -->
                    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">Instructor</h3>
                        <div class="flex items-center mb-3">
                            <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center">
                                <span class="text-indigo-600 font-semibold text-lg">
                                    <?php echo e(substr($course->teacher->name ?? 'T', 0, 1)); ?>

                                </span>
                            </div>
                            <div class="ml-3">
                                <p class="font-semibold text-gray-900"><?php echo e($course->teacher->name ?? 'Teacher'); ?></p>
                                <p class="text-sm text-gray-600"><?php echo e($course->teacher->email ?? ''); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Course Features -->
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h3 class="text-lg font-bold text-gray-900 mb-4">This course includes</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700"><?php echo e($course->is_lifetime ? 'Lifetime' : $course->validity_period . ' ' . $course->validity_unit); ?> access</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Certificate of completion</span>
                            </li>
                            <li class="flex items-start">
                                <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">Access on mobile and desktop</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Related Courses -->
            <?php if($relatedCourses && $relatedCourses->count() > 0): ?>
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Related Courses</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <?php $__currentLoopData = $relatedCourses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e(route('courses.show', $related->id)); ?>" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                        <?php if($related->thumbnail): ?>
                            <img class="h-48 w-full object-cover" src="/storage/<?php echo e($related->thumbnail); ?>" alt="<?php echo e($related->title); ?>">
                        <?php else: ?>
                            <div class="h-48 w-full bg-blue-100 flex items-center justify-center">
                                <svg class="w-12 h-12 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                </svg>
                            </div>
                        <?php endif; ?>
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-900 mb-2"><?php echo e($related->title); ?></h3>
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2"><?php echo e(Str::limit($related->description, 80)); ?></p>
                            <div class="flex items-center justify-between">
                                <span class="text-lg font-bold text-gray-900">₹<?php echo e(number_format($related->price, 2)); ?></span>
                                <span class="text-sm text-gray-600"><?php echo e($related->enrollments_count); ?> students</span>
                            </div>
                        </div>
                    </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
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
<?php /**PATH C:\laragon\www\paathshaala\resources\views/courses/show.blade.php ENDPATH**/ ?>