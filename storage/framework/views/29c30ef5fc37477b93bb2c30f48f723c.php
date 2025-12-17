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
            My Wallet
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="max-w-7xl mx-auto">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <!-- Available Balance -->
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-lg shadow p-6 border border-green-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Available Balance</p>
                        <p class="text-3xl font-bold text-green-600">₹<?php echo e(number_format($wallet->balance ?? 0, 2)); ?></p>
                    </div>
                    <svg class="w-12 h-12 text-green-400 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                    </svg>
                </div>
            </div>

            <!-- Total Earned -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg shadow p-6 border border-blue-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Earned</p>
                        <p class="text-3xl font-bold text-blue-600">₹<?php echo e(number_format($stats['total_earned'] ?? 0, 2)); ?></p>
                    </div>
                    <svg class="w-12 h-12 text-blue-400 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M12 2a1 1 0 01.894.553l1.659 3.318a1 1 0 00.894.553h3.668a1 1 0 01.707 1.707l-2.829 2.829a1 1 0 00-.306 1.118l1.659 3.318a1 1 0 01-1.414 1.414L10 12.236l-2.829 2.829a1 1 0 01-1.414-1.414l1.659-3.318a1 1 0 00-.306-1.118L4.034 8.131a1 1 0 01.707-1.707h3.668a1 1 0 00.894-.553l1.659-3.318A1 1 0 0112 2z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>

            <!-- Total Withdrawn -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-lg shadow p-6 border border-purple-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Total Withdrawn</p>
                        <p class="text-3xl font-bold text-purple-600">₹<?php echo e(number_format($stats['total_withdrawn'] ?? 0, 2)); ?></p>
                    </div>
                    <svg class="w-12 h-12 text-purple-400 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M19.5 10a.5.5 0 00-.5-.5h-1.362l-.165-1.652a.5.5 0 00-.986.164l.164 1.652H15.5a.5.5 0 000 1h1.362l.165 1.652a.5.5 0 00.986-.164l-.164-1.652H19a.5.5 0 00.5-.5zM8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>

            <!-- Pending Withdrawals -->
            <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-lg shadow p-6 border border-yellow-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-600 mb-1">Pending Withdrawals</p>
                        <p class="text-3xl font-bold text-yellow-600">₹<?php echo e(number_format($stats['pending_withdrawals'] ?? 0, 2)); ?></p>
                    </div>
                    <svg class="w-12 h-12 text-yellow-400 opacity-50" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 11-2 0 1 1 0 012 0zm-1 5a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="flex flex-wrap gap-3">
                        <a href="<?php echo e(route('instructor.wallet.withdraw')); ?>" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 font-medium">
                            <!-- <svg class="inline-block w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg> -->
                            Request Withdrawal
                        </a>
                    </div>
                </div>

                <!-- Transactions History -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Transaction History</h3>
                    </div>

                    <?php if(isset($transactions) && $transactions->count() > 0): ?>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php $__currentLoopData = $transactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo e($transaction->created_at->format('M d, Y H:i')); ?>

                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <?php echo e($transaction->description ?? 'N/A'); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            <?php if($transaction->type === 'credit'): ?> bg-green-100 text-green-800
                                            <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                            <?php echo e(ucfirst($transaction->type)); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold
                                        <?php if($transaction->type === 'credit'): ?> text-green-600
                                        <?php else: ?> text-red-600 <?php endif; ?>">
                                        <?php if($transaction->type === 'credit'): ?> + <?php else: ?> - <?php endif; ?> ₹<?php echo e(number_format($transaction->amount, 2)); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        ₹<?php echo e(number_format($transaction->balance_after ?? 0, 2)); ?>

                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <?php if(isset($transactions) && $transactions instanceof \Illuminate\Pagination\Paginator && $transactions->hasPages()): ?>
                    <div class="px-6 py-4 border-t border-gray-200">
                        <?php echo e($transactions->links()); ?>

                    </div>
                    <?php endif; ?>
                    <?php else: ?>
                    <div class="text-center py-12">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" 
     fill="none" stroke="currentColor" stroke-width="2" 
     class="mx-auto h-12 w-12 text-gray-400">
  <path d="M6 4h12M6 9h9M6 4c6 0 6 9 0 9l7 7" stroke-linecap="round" stroke-linejoin="round"/>
</svg>


                        <p class="mt-4 text-gray-500">No transactions yet</p>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sidebar -->
            <div>
                <!-- Withdrawal Status -->
                <div class="bg-white rounded-lg shadow p-6 mb-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Withdrawal Requests</h3>
                    
                    <?php if(isset($withdrawRequests) && $withdrawRequests->count() > 0): ?>
                    <div class="space-y-3">
                        <?php $__currentLoopData = $withdrawRequests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="p-3 border border-gray-200 rounded-lg">
                            <div class="flex justify-between items-start mb-2">
                                <span class="font-semibold text-gray-900">₹<?php echo e(number_format($request->amount, 2)); ?></span>
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    <?php if($request->status === 'pending'): ?> bg-yellow-100 text-yellow-800
                                    <?php elseif($request->status === 'approved'): ?> bg-green-100 text-green-800
                                    <?php elseif($request->status === 'paid'): ?> bg-blue-100 text-blue-800
                                    <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                    <?php echo e(ucfirst($request->status)); ?>

                                </span>
                            </div>
                            <p class="text-xs text-gray-500"><?php echo e($request->created_at->format('M d, Y H:i')); ?></p>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <?php else: ?>
                    <p class="text-gray-500 text-center py-6">No withdrawal requests yet</p>
                    <?php endif; ?>
                </div>

                <!-- Helpful Info -->
                <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                    <h3 class="font-semibold text-green-900 mb-3">How to Use Your Wallet</h3>
                    <ul class="text-sm text-green-800 space-y-2">
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Earn money from course sales</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>Request withdrawal anytime</span>
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <span>View all transactions in history</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
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
<?php /**PATH C:\laragon\www\paathshaala\resources\views/instructor/wallet/index.blade.php ENDPATH**/ ?>