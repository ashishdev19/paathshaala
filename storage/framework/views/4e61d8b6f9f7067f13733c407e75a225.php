

<?php $__env->startSection('title', 'Browse Courses'); ?>

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-4xl font-bold text-gray-900 mb-2">Browse Courses</h1>
            <p class="text-lg text-gray-600">Explore our comprehensive collection of courses and start learning today</p>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <input type="text" placeholder="Search courses..." class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>
                <div>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Categories</option>
                        <option value="medical">Medical</option>
                        <option value="nursing">Nursing</option>
                        <option value="pharmacy">Pharmacy</option>
                        <option value="engineering">Engineering</option>
                    </select>
                </div>
                <div>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">All Levels</option>
                        <option value="beginner">Beginner</option>
                        <option value="intermediate">Intermediate</option>
                        <option value="advanced">Advanced</option>
                    </select>
                </div>
                <div>
                    <select class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <option value="">Sort by</option>
                        <option value="newest">Newest</option>
                        <option value="popular">Most Popular</option>
                        <option value="rating">Highest Rated</option>
                        <option value="price_low">Price: Low to High</option>
                        <option value="price_high">Price: High to Low</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Courses Grid -->
        <?php if($courses->count() > 0): ?>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-lg shadow hover:shadow-lg transition overflow-hidden">
                        <!-- Course Image -->
                        <div class="relative bg-gray-200 h-48">
                            <?php if($course->thumbnail): ?>
                                <img src="<?php echo e(asset($course->thumbnail)); ?>" alt="<?php echo e($course->title); ?>" class="w-full h-full object-cover">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-400 to-blue-600">
                                    <i class="fas fa-book text-white text-6xl opacity-50"></i>
                                </div>
                            <?php endif; ?>
                            <div class="absolute top-3 right-3">
                                <span class="bg-blue-600 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    <?php echo e($course->level ?? 'Beginner'); ?>

                                </span>
                            </div>
                        </div>

                        <!-- Course Info -->
                        <div class="p-4">
                            <!-- Teacher -->
                            <div class="flex items-center mb-2">
                                <img src="<?php echo e($course->teacher->profile_photo_url ?? asset('img/default-avatar.png')); ?>" alt="<?php echo e($course->teacher->name); ?>" class="w-8 h-8 rounded-full mr-2">
                                <span class="text-sm text-gray-600"><?php echo e($course->teacher->name); ?></span>
                            </div>

                            <!-- Title -->
                            <h3 class="text-lg font-bold text-gray-900 mb-2 line-clamp-2"><?php echo e($course->title); ?></h3>

                            <!-- Description -->
                            <p class="text-sm text-gray-600 mb-3 line-clamp-2"><?php echo e($course->description); ?></p>

                            <!-- Rating -->
                            <div class="flex items-center mb-3">
                                <?php if($course->reviews_count > 0): ?>
                                    <?php
                                        $avgRating = $course->reviews->avg('rating');
                                    ?>
                                    <div class="flex text-yellow-400">
                                        <?php for($i = 0; $i < 5; $i++): ?>
                                            <?php if($i < round($avgRating)): ?>
                                                <i class="fas fa-star"></i>
                                            <?php else: ?>
                                                <i class="far fa-star"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="text-sm text-gray-600 ml-2">(<?php echo e($course->reviews_count); ?>)</span>
                                <?php else: ?>
                                    <span class="text-sm text-gray-500">No ratings yet</span>
                                <?php endif; ?>
                            </div>

                            <!-- Stats -->
                            <div class="flex items-center justify-between text-sm text-gray-600 mb-4 py-2 border-y">
                                <span><i class="fas fa-users mr-1"></i><?php echo e($course->enrollments_count ?? 0); ?> students</span>
                                <span><i class="fas fa-clock mr-1"></i><?php echo e($course->duration ?? 0); ?> hours</span>
                            </div>

                            <!-- Price and Button -->
                            <div class="flex items-center justify-between">
                                <div>
                                    <span class="text-2xl font-bold text-gray-900">₹<?php echo e(number_format($course->price ?? 0, 0)); ?></span>
                                    <?php if($course->original_price && $course->original_price > $course->price): ?>
                                        <span class="text-sm text-gray-500 line-through ml-2">₹<?php echo e(number_format($course->original_price, 0)); ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>

                            <!-- Button -->
                            <a href="<?php echo e(route('courses.show', $course->id)); ?>" class="block w-full mt-4 bg-blue-600 text-white py-2 rounded-lg text-center hover:bg-blue-700 transition font-semibold">
                                View Course
                            </a>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                <?php echo e($courses->links()); ?>

            </div>
        <?php else: ?>
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <i class="fas fa-book fa-4x text-gray-400 mb-4"></i>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No Courses Found</h3>
                <p class="text-gray-600 mb-6">We couldn't find any courses matching your criteria. Try adjusting your filters.</p>
                <a href="<?php echo e(route('courses')); ?>" class="inline-block bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                    Browse All Courses
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\paathshaala\resources\views/admin/courses/public-index.blade.php ENDPATH**/ ?>