<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['min:5', 'max:50', Rule::unique(User::class)->ignore($this->user()->id)],
            'email' => ['email', 'max:255', Rule::unique(User::class)->ignore($this->user()->id)],
            'firstname' => 'required|string|max:70',
            'lastname' => 'required|string|max:70',
            'title' => 'nullable|string|max:50',
            'phone_home' => 'nullable|string|max:50',
            'phone_mobile' => 'nullable|string|max:50',
            'phone_work' => 'nullable|string|max:50',
        ];
    }
}
