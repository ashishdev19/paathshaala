<!-- Course Rating and Reviews Component -->
<div class="bg-white rounded-lg shadow p-6" x-data="{ 
    showReviewForm: false, 
    rating: 0, 
    hoveredRating: 0,
    reviewText: '',
    pros: [],
    cons: [],
    newPro: '',
    newCon: '',
    tags: []
}">
    <!-- Overall Rating Summary -->
    <div class="mb-8">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-gray-900">Student Reviews</h3>
            @auth
                @if($canReview)
                <button @click="showReviewForm = !showReviewForm" 
                        class="bg-indigo-600 text-white px-4 py-2 rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">
                    Write a Review
                </button>
                @endif
            @endauth
        </div>

        @if($course->reviews->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Rating Overview -->
            <div>
                <div class="flex items-center mb-4">
                    <div class="text-4xl font-bold text-gray-900 mr-4">{{ number_format($averageRating, 1) }}</div>
                    <div>
                        <div class="flex items-center mb-1">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-5 h-5 {{ $i <= $averageRating ? 'text-yellow-400' : 'text-gray-300' }}" 
                                     fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                </svg>
                            @endfor
                        </div>
                        <div class="text-sm text-gray-600">{{ $course->reviews->count() }} {{ Str::plural('review', $course->reviews->count()) }}</div>
                    </div>
                </div>

                <!-- Rating Breakdown -->
                <div class="space-y-2">
                    @for($i = 5; $i >= 1; $i--)
                        @php
                            $count = $course->reviews->where('course_rating', $i)->count();
                            $percentage = $course->reviews->count() > 0 ? ($count / $course->reviews->count()) * 100 : 0;
                        @endphp
                        <div class="flex items-center">
                            <span class="text-sm text-gray-600 w-8">{{ $i }}</span>
                            <svg class="w-4 h-4 text-yellow-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                            <div class="flex-1 bg-gray-200 rounded-full h-2 mx-2">
                                <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <span class="text-sm text-gray-600 w-8">{{ $count }}</span>
                        </div>
                    @endfor
                </div>
            </div>

            <!-- Review Highlights -->
            <div>
                <h4 class="font-semibold text-gray-900 mb-3">What Students Say</h4>
                @if($featuredReviews->count() > 0)
                    <div class="space-y-3">
                        @foreach($featuredReviews->take(3) as $review)
                            <div class="bg-gray-50 rounded-lg p-3">
                                <div class="flex items-center mb-2">
                                    <div class="w-8 h-8 bg-indigo-500 rounded-full flex items-center justify-center text-white text-sm font-medium mr-3">
                                        {{ $review->student_initials }}
                                    </div>
                                    <div>
                                        <div class="font-medium text-gray-900">{{ $review->student->name }}</div>
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-3 h-3 {{ $i <= $review->overall_rating ? 'text-yellow-400' : 'text-gray-300' }}" 
                                                     fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600">"{{ Str::limit($review->review_content, 100) }}"</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
        @else
        <div class="text-center py-8">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.921-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No reviews yet</h3>
            <p class="mt-1 text-sm text-gray-500">Be the first to review this course!</p>
        </div>
        @endif
    </div>

    <!-- Review Form -->
    <div x-show="showReviewForm" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95"
         class="mb-8 bg-gray-50 rounded-lg p-6">
        
        <h4 class="text-lg font-semibold text-gray-900 mb-4">Write Your Review</h4>
        
        <form method="POST" action="{{ route('courses.review', $course) }}">
            @csrf
            
            <!-- Rating -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Overall Rating</label>
                <div class="flex items-center space-x-1">
                    <template x-for="i in 5" :key="i">
                        <button type="button"
                                @click="rating = i"
                                @mouseenter="hoveredRating = i"
                                @mouseleave="hoveredRating = 0"
                                class="focus:outline-none">
                            <svg class="w-8 h-8 transition-colors duration-200" 
                                 :class="i <= (hoveredRating || rating) ? 'text-yellow-400' : 'text-gray-300'"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </button>
                    </template>
                </div>
                <input type="hidden" name="rating" x-bind:value="rating">
            </div>

            <!-- Review Text -->
            <div class="mb-6">
                <label for="review_text" class="block text-sm font-medium text-gray-700 mb-2">Your Review</label>
                <textarea name="review_text" id="review_text" rows="4" x-model="reviewText"
                          placeholder="Share your experience with this course..."
                          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"></textarea>
            </div>

            <!-- Pros and Cons -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Pros -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">What did you like?</label>
                    <div class="space-y-2 mb-3">
                        <template x-for="(pro, index) in pros" :key="index">
                            <div class="flex items-center bg-green-50 rounded-lg px-3 py-2">
                                <span class="flex-1 text-sm text-green-800" x-text="pro"></span>
                                <button type="button" @click="pros.splice(index, 1)" 
                                        class="text-green-600 hover:text-green-800 ml-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                    <div class="flex">
                        <input type="text" x-model="newPro" 
                               placeholder="Add a positive point..."
                               class="flex-1 border border-gray-300 rounded-l-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <button type="button" @click="if(newPro.trim()) { pros.push(newPro.trim()); newPro = ''; }"
                                class="bg-green-600 text-white px-4 py-2 rounded-r-lg hover:bg-green-700 transition duration-300">
                            Add
                        </button>
                    </div>
                </div>

                <!-- Cons -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">What could be improved?</label>
                    <div class="space-y-2 mb-3">
                        <template x-for="(con, index) in cons" :key="index">
                            <div class="flex items-center bg-red-50 rounded-lg px-3 py-2">
                                <span class="flex-1 text-sm text-red-800" x-text="con"></span>
                                <button type="button" @click="cons.splice(index, 1)" 
                                        class="text-red-600 hover:text-red-800 ml-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </template>
                    </div>
                    <div class="flex">
                        <input type="text" x-model="newCon" 
                               placeholder="Add an improvement suggestion..."
                               class="flex-1 border border-gray-300 rounded-l-lg px-3 py-2 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <button type="button" @click="if(newCon.trim()) { cons.push(newCon.trim()); newCon = ''; }"
                                class="bg-red-600 text-white px-4 py-2 rounded-r-lg hover:bg-red-700 transition duration-300">
                            Add
                        </button>
                    </div>
                </div>
            </div>

            <!-- Hidden inputs for pros and cons -->
            <input type="hidden" name="pros" x-bind:value="JSON.stringify(pros)">
            <input type="hidden" name="cons" x-bind:value="JSON.stringify(cons)">

            <!-- Submit Button -->
            <div class="flex justify-end space-x-4">
                <button type="button" @click="showReviewForm = false" 
                        class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition duration-300">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-6 py-3 bg-indigo-600 text-white rounded-lg font-semibold hover:bg-indigo-700 transition duration-300">
                    Submit Review
                </button>
            </div>
        </form>
    </div>

    <!-- Reviews List -->
    @if($course->reviews->count() > 0)
    <div class="space-y-6">
        <h4 class="text-lg font-semibold text-gray-900">All Reviews</h4>
        
        @foreach($course->reviews()->approved()->orderBy('created_at', 'desc')->get() as $review)
            <div class="border border-gray-200 rounded-lg p-6">
                <div class="flex items-start justify-between mb-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-12 h-12 bg-indigo-500 rounded-full flex items-center justify-center text-white font-medium">
                            {{ $review->student_initials }}
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">{{ $review->student->name }}</div>
                            <div class="flex items-center space-x-2">
                                <div class="flex">
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-4 h-4 {{ $i <= $review->overall_rating ? 'text-yellow-400' : 'text-gray-300' }}" 
                                             fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                    @endfor
                                </div>
                                <span class="text-sm text-gray-500">{{ $review->time_ago }}</span>
                                @if($review->is_verified)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Verified
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                @if($review->review_content)
                    <p class="text-gray-600 mb-4">{{ $review->review_content }}</p>
                @endif

                @if($review->pros || $review->cons)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        @if($review->pros)
                            <div>
                                <h5 class="font-medium text-green-800 mb-2">👍 Liked</h5>
                                <ul class="space-y-1">
                                    @foreach($review->pros as $pro)
                                        <li class="text-sm text-green-700 bg-green-50 rounded px-2 py-1">{{ $pro }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if($review->cons)
                            <div>
                                <h5 class="font-medium text-red-800 mb-2">👎 Could Improve</h5>
                                <ul class="space-y-1">
                                    @foreach($review->cons as $con)
                                        <li class="text-sm text-red-700 bg-red-50 rounded px-2 py-1">{{ $con }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <button class="flex items-center space-x-2 text-gray-500 hover:text-gray-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-4 0v5m7 5v-5m-8 5H3m8 0H7"/>
                        </svg>
                        <span class="text-sm">Helpful ({{ $review->helpful_count }})</span>
                    </button>
                </div>
            </div>
        @endforeach
    </div>
    @endif
</div>