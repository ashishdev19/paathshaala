<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTeacherEnquiryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:teacher_enquiries|unique:users,email',
            'phone_number' => 'required|string|max:20|regex:/^[0-9\-\+\(\)\s]+$/',
            'qualification' => 'required|string|max:255',
            'experience' => 'required|integer|min:0|max:70',
            'bio' => 'required|string|min:50|max:1000',
            'subject_expertise' => 'required|string|min:10|max:500',
            'plan_id' => 'required|exists:subscription_plans,id|integer',
            'agree_terms' => 'required|accepted',
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => 'Full name is required.',
            'email.required' => 'Email is required.',
            'email.unique' => 'This email is already registered.',
            'phone_number.required' => 'Phone number is required.',
            'phone_number.regex' => 'Phone number format is invalid.',
            'qualification.required' => 'Qualification is required.',
            'experience.required' => 'Years of experience is required.',
            'experience.integer' => 'Experience must be a number.',
            'bio.required' => 'Bio is required.',
            'bio.min' => 'Bio must be at least 50 characters.',
            'subject_expertise.required' => 'Subject expertise is required.',
            'plan_id.required' => 'Please select a subscription plan.',
            'agree_terms.required' => 'You must agree to the terms and conditions.',
        ];
    }
}
