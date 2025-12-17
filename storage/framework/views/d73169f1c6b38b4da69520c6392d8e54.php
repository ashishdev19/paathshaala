<?php if (isset($component)) { $__componentOriginalc1b21f86893e3b1d0f1a6afe3cbde8cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc1b21f86893e3b1d0f1a6afe3cbde8cc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.layouts.instructor','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('layouts.instructor'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            Live Classes
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="bg-white rounded-lg shadow-md overflow-hidden border border-gray-200">
        <!-- Header with Schedule Button -->
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gradient-to-r from-indigo-50 to-purple-50">
            <h3 class="text-lg font-semibold text-gray-900">Scheduled Live Classes</h3>
            <a href="<?php echo e(route('instructor.live-classes.create')); ?>" class="bg-gradient-to-r from-green-600 to-green-700 text-white px-4 py-2 rounded-lg hover:from-green-700 hover:to-green-800 transition font-semibold shadow-md">
                <svg class="inline-block h-5 w-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Schedule New Class
            </a>
        </div>

        <!-- Success Message -->
        <?php if(session('success')): ?>
            <div class="mx-6 mt-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <!-- Filter Section -->
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center gap-4">
                <label class="text-sm font-semibold text-gray-700">Filter by Status:</label>
                <div class="relative">
                    <select id="statusFilter" onchange="filterByStatus(this.value)" class="appearance-none bg-white border border-indigo-300 rounded-lg px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-indigo-500 text-sm font-medium text-gray-700 cursor-pointer">
                        <option value="">All Status</option>
                        <option value="upcoming">Upcoming</option>
                        <option value="live">Live Now</option>
                        <option value="completed">Completed</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                    <svg class="absolute right-3 top-3 w-4 h-4 text-gray-700 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Classes Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-indigo-50 to-purple-50">
                    <tr>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-indigo-900 uppercase tracking-wider">Course</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-indigo-900 uppercase tracking-wider">Topic</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-indigo-900 uppercase tracking-wider">Date & Time</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-indigo-900 uppercase tracking-wider">Duration</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-indigo-900 uppercase tracking-wider">Mode</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-indigo-900 uppercase tracking-wider">Status</th>
                        <th class="px-5 py-4 text-left text-xs font-semibold text-indigo-900 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $liveClasses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php
                        // Determine status based on datetime
                        $now = \Carbon\Carbon::now();
                        $startTime = $class->start_datetime;
                        $endTime = $startTime->copy()->addMinutes($class->duration);
                        
                        if ($class->status === 'cancelled') {
                            $status = 'cancelled';
                        } elseif ($now->isBefore($startTime)) {
                            $status = 'upcoming';
                        } elseif ($now->isBetween($startTime, $endTime)) {
                            $status = 'live';
                        } else {
                            $status = 'completed';
                        }
                    ?>
                    <tr class="hover:bg-gray-50 transition duration-200 <?php echo e($index % 2 === 0 ? 'bg-white' : 'bg-gray-50'); ?>">
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">
                                <?php echo e($class->course->title ?? 'General'); ?>

                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="text-sm font-medium text-gray-900"><?php echo e($class->topic); ?></div>
                            <?php if($class->description): ?>
                                <div class="text-xs text-gray-500 mt-1"><?php echo e(Str::limit($class->description, 50)); ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center text-sm text-gray-900 font-medium">
                                <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                                <?php echo e($class->start_datetime->format('M d, Y')); ?>

                            </div>
                            <div class="flex items-center text-xs text-gray-500 mt-1">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 2m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <?php echo e($class->start_datetime->format('h:i A')); ?>

                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center text-sm font-medium text-gray-600">
                                <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 2m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <?php echo e($class->duration); ?> mins
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                <?php if($class->mode === 'online'): ?> bg-blue-100 text-blue-800 border border-blue-200
                                <?php elseif($class->mode === 'offline'): ?> bg-purple-100 text-purple-800 border border-purple-200
                                <?php else: ?> bg-indigo-100 text-indigo-800 border border-indigo-200 <?php endif; ?>">
                                <?php echo e(ucfirst($class->mode)); ?>

                            </span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="relative group">
                                <button class="px-3 py-1 text-xs font-semibold rounded-full inline-flex items-center
                                    <?php if($status === 'upcoming'): ?> bg-indigo-100 text-indigo-800 border border-indigo-200
                                    <?php elseif($status === 'live'): ?> bg-green-100 text-green-800 border border-green-200 animate-pulse
                                    <?php elseif($status === 'completed'): ?> bg-gray-100 text-gray-800 border border-gray-300
                                    <?php else: ?> bg-red-100 text-red-800 border border-red-200 <?php endif; ?>">
                                    <svg class="w-3 h-3 mr-1.5" fill="currentColor" viewBox="0 0 8 8">
                                        <circle cx="4" cy="4" r="2.5"/>
                                    </svg>
                                    <?php if($status === 'upcoming'): ?> Upcoming
                                    <?php elseif($status === 'live'): ?> Live Now
                                    <?php elseif($status === 'completed'): ?> Completed
                                    <?php else: ?> Cancelled <?php endif; ?>
                                </button>

                                <!-- Status Dropdown -->
                                <div class="absolute right-0 mt-1 w-40 bg-white rounded-lg shadow-xl border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-20">
                                    <div class="p-3 space-y-2">
                                        <button onclick="updateStatus(<?php echo e($class->id); ?>, 'upcoming')" class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-indigo-50 rounded-lg transition duration-150 flex items-center">
                                            <span class="inline-block w-2 h-2 rounded-full bg-indigo-600 mr-2"></span>
                                            Upcoming
                                        </button>
                                        <button onclick="updateStatus(<?php echo e($class->id); ?>, 'live')" class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-green-50 rounded-lg transition duration-150 flex items-center">
                                            <span class="inline-block w-2 h-2 rounded-full bg-green-600 mr-2 animate-pulse"></span>
                                            Live Now
                                        </button>
                                        <button onclick="updateStatus(<?php echo e($class->id); ?>, 'completed')" class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-gray-50 rounded-lg transition duration-150 flex items-center">
                                            <span class="inline-block w-2 h-2 rounded-full bg-gray-600 mr-2"></span>
                                            Completed
                                        </button>
                                        <button onclick="updateStatus(<?php echo e($class->id); ?>, 'cancelled')" class="w-full text-left px-3 py-2 text-sm text-gray-700 hover:bg-red-50 rounded-lg transition duration-150 flex items-center">
                                            <span class="inline-block w-2 h-2 rounded-full bg-red-600 mr-2"></span>
                                            Cancelled
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-2">
                                <!-- View Button -->
                                <a href="<?php echo e(route('instructor.live-classes.show', $class->id)); ?>" 
                                   class="inline-flex items-center px-3 py-2 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition duration-200 group/item"
                                   title="View details">
                                    <svg class="w-4 h-4 group-hover/item:scale-110 transition duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                    </svg>
                                </a>

                                <!-- Edit Button -->
                                <a href="<?php echo e(route('instructor.live-classes.edit', $class->id)); ?>" 
                                   class="inline-flex items-center px-3 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition duration-200 group/item"
                                   title="Edit class">
                                    <svg class="w-4 h-4 group-hover/item:scale-110 transition duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                    </svg>
                                </a>

                                <!-- Delete Button -->
                                <form action="<?php echo e(route('instructor.live-classes.destroy', $class->id)); ?>" method="POST" class="inline-block">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" 
                                            onclick="return confirm('Are you sure you want to delete this class?')"
                                            class="inline-flex items-center px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition duration-200 group/item"
                                            title="Delete class">
                                        <svg class="w-4 h-4 group-hover/item:scale-110 transition duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-16 text-center">
                            <svg class="mx-auto h-16 w-16 text-indigo-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                            </svg>
                            <p class="text-lg font-semibold text-gray-800 mb-2">No live classes scheduled</p>
                            <p class="text-sm text-gray-600 mb-6">Schedule your first live class to get started</p>
                            <a href="<?php echo e(route('instructor.live-classes.create')); ?>" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg hover:from-green-700 hover:to-green-800 shadow-md font-semibold transition duration-300">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Schedule New Class
                            </a>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if($liveClasses->hasPages()): ?>
            <div class="px-6 py-4 border-t border-gray-200">
                <?php echo e($liveClasses->links()); ?>

            </div>
        <?php endif; ?>
    </div>

    <script>
        function filterByStatus(status) {
            const rows = document.querySelectorAll('tbody tr');
            
            rows.forEach(row => {
                // Skip the empty state row
                if (row.querySelector('svg[class*="indigo-400"]')) {
                    return;
                }
                
                // Get the status badge from the row (now in Status column, not Actions)
                const statusBadge = row.querySelector('td:nth-child(6) button');
                if (!statusBadge) {
                    return;
                }
                
                const rowStatus = statusBadge.textContent.toLowerCase().trim();
                
                // Convert badge text to status value
                let statusValue = '';
                if (rowStatus.includes('upcoming')) statusValue = 'upcoming';
                else if (rowStatus.includes('live')) statusValue = 'live';
                else if (rowStatus.includes('completed')) statusValue = 'completed';
                else if (rowStatus.includes('cancelled')) statusValue = 'cancelled';
                
                // Show or hide row based on filter
                if (status === '' || statusValue === status) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function updateStatus(classId, status) {
            // This would send a request to update the status in the database
            console.log('Update class', classId, 'status to', status);
            // You can implement API call here
        }
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc1b21f86893e3b1d0f1a6afe3cbde8cc)): ?>
<?php $attributes = $__attributesOriginalc1b21f86893e3b1d0f1a6afe3cbde8cc; ?>
<?php unset($__attributesOriginalc1b21f86893e3b1d0f1a6afe3cbde8cc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc1b21f86893e3b1d0f1a6afe3cbde8cc)): ?>
<?php $component = $__componentOriginalc1b21f86893e3b1d0f1a6afe3cbde8cc; ?>
<?php unset($__componentOriginalc1b21f86893e3b1d0f1a6afe3cbde8cc); ?>
<?php endif; ?>
<?php /**PATH C:\laragon\www\paathshaala\resources\views/instructor/live-classes/index.blade.php ENDPATH**/ ?>