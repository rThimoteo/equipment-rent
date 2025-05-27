<?php

namespace App\Http\Requests;

use App\Rules\EquipmentAvailable;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRentalRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rental = $this->route('rental');

        return [
            'start_date' => [
                'required',
                'date',
                'before:end_date',
                new EquipmentAvailable($this->start_date, $this->end_date, $rental)
            ],
            'end_date' => 'required|date|after:start_date',
        ];
    }
}
