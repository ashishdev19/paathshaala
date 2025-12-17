<?php

namespace App\Http\Requests\Instructor;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization handled by middleware
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:course_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'duration' => 'required|string|max:100',
            'class_start_time' => 'nullable|date_format:H:i',
            'class_end_time' => 'nullable|date_format:H:i|after:class_start_time',
            'mode' => 'required|in:online,offline,hybrid',
            'batch_start_date' => 'nullable|date',
            'batch_end_date' => 'nullable|date|after_or_equal:batch_start_date',
            'price' => 'nullable|numeric|min:0',
            'is_free' => 'nullable|boolean',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    /**
     * Get custom validation messages.
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'Please select a course category.',
            'category_id.exists' => 'Selected category does not exist.',
            'title.required' => 'Course title is required.',
            'description.required' => 'Course description is required.',
            'duration.required' => 'Course duration is required.',
            'class_end_time.after' => 'Class end time must be after start time.',
            'batch_end_date.after_or_equal' => 'Batch end date must be equal to or after the start date.',
            'mode.required' => 'Please select a course mode.',
            'mode.in' => 'Course mode must be online, offline, or hybrid.',
        ];
    }
}
