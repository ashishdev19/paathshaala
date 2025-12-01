<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $courseId = $this->route('course')->id ?? null;

        return [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'required|string|min:50',
            'category' => 'required|string|max:100',
            'level' => 'required|in:beginner,intermediate,advanced',
            'language' => 'required|string|max:50',
            'course_mode' => 'required|in:online,offline,hybrid',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'promo_video_url' => 'nullable|url',
            'demo_pdf' => 'nullable|file|mimes:pdf|max:5120',
            'demo_lecture' => 'nullable|file|mimes:mp4,avi,mov,mkv|max:51200',
            'is_free' => 'boolean',
            'price' => 'required_if:is_free,false|nullable|numeric|min:0|max:999999',
            'discount_price' => 'nullable|numeric|min:0|max:999999',
            'validity_days' => 'nullable|integer|min:1|max:36500',
            'meta_title' => 'nullable|string|max:160',
            'meta_description' => 'nullable|string|max:160',
            'slug' => "nullable|string|max:255|unique:courses,slug,{$courseId}",
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Course title is required',
            'description.required' => 'Course description is required',
            'description.min' => 'Course description must be at least 50 characters',
            'category.required' => 'Please select a category',
            'level.required' => 'Please select a level',
        ];
    }
}
