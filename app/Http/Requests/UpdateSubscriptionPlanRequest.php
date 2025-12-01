<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubscriptionPlanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    public function rules(): array
    {
        $planId = $this->route('plan')->id ?? null;

        return [
            'name' => 'required|string|max:255|unique:subscription_plans,name,' . $planId,
            'slug' => 'required|string|max:255|unique:subscription_plans,slug,' . $planId,
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0|max:999999.99',
            'features' => 'nullable|json',
            'max_students' => 'nullable|integer|min:0|max:10000',
            'max_courses' => 'nullable|integer|min:0|max:10000',
            'priority' => 'nullable|integer|min:0|max:100',
            'is_active' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Plan name is required.',
            'name.unique' => 'This plan name already exists.',
            'slug.required' => 'Plan slug is required.',
            'slug.unique' => 'This plan slug already exists.',
            'price.required' => 'Plan price is required.',
            'price.numeric' => 'Plan price must be a number.',
            'price.min' => 'Plan price cannot be negative.',
            'features.json' => 'Features must be valid JSON.',
            'max_students.integer' => 'Max students must be a number.',
            'max_courses.integer' => 'Max courses must be a number.',
        ];
    }
}
