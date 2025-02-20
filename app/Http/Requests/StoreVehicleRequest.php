<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'registration_number' => 'required|string|max:15',
            'make' => 'required|string|max:50',
            'model' => 'required|string|max:50',
            'year' => [
                'required',
                'integer',
                'digits:4',
                'between:1950,'.(date('Y') + 1),
            ],
            'color' => 'nullable|max:25',
            'engine_size' => 'nullable|max:25',
            'fuel_type' => 'nullable|max:25',
            'mot_due_date' => 'nullable|date',
            'tax_due_date' => 'nullable|date',
            'insurance_due_date' => 'nullable|date',
        ];
    }
}
