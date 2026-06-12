<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [

            // User Fields
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],

            'phone' => ['required', 'digits_between:10,15'],

            // Profile Fields
            'age' => ['required', 'integer', 'min:18', 'max:100'],

            'religion' => ['required', 'string', 'max:100'],

            'community' => ['required', 'string', 'max:100'],

            'marital_status' => [
                'required',
                'in:single,divorced,widow'
            ],

            'profession' => ['required', 'string', 'max:255'],

            'country' => ['required'],

            'state' => ['required'],

            'city' => ['required'],

            'visibility' => [
                'required',
                'in:public,private'
            ],

            // Profile Image (optional while editing)
            'profile_image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048'
            ],

            // Partner Preferences
            'preferences.age_min' => [
                'nullable',
                'integer',
                'min:18',
                'max:100'
            ],

            'preferences.age_max' => [
                'nullable',
                'integer',
                'min:18',
                'max:100',
                'gte:preferences.age_min'
            ],

            'preferences.religion' => [
                'nullable',
                'string',
                'max:100'
            ],

            'preferences.Cast' => [
                'nullable',
                'string',
                'max:100'
            ],

            'preferences.location' => [
                'nullable',
                'array'
            ],

            'preferences.location.*' => [
                'nullable',
                'string'
            ],

            'preferences.marital_status' => [
                'nullable',
                'array'
            ],

            'preferences.marital_status.*' => [
                'nullable',
                'string'
            ],

            'preferences.profession' => [
                'nullable',
                'array'
            ],

            'preferences.profession.*' => [
                'nullable',
                'string'
            ],

            'preferences.personality' => [
                'nullable',
                'array'
            ],

            'preferences.personality.*' => [
                'nullable',
                'string'
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Full name is required.',

            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already taken.',

            'phone.required' => 'Phone number is required.',
            'phone.digits_between' => 'Phone number must be between 10 and 15 digits.',

            'age.required' => 'Age is required.',
            'age.min' => 'Age must be at least 18 years.',
            'age.max' => 'Age cannot exceed 100 years.',

            'religion.required' => 'Religion is required.',
            'community.required' => 'Community is required.',

            'marital_status.required' => 'Please select marital status.',

            'profession.required' => 'Profession is required.',

            'country.required' => 'Please select a country.',
            'state.required' => 'Please select a state.',
            'city.required' => 'Please select a city.',

            'visibility.required' => 'Please select profile visibility.',

            'profile_image.image' => 'Please upload a valid image.',
            'profile_image.mimes' => 'Image must be JPG, JPEG, PNG or WEBP.',
            'profile_image.max' => 'Image size must not exceed 2MB.',

            'preferences.age_max.gte' =>
                'Maximum age must be greater than or equal to minimum age.',
        ];
    }
}
