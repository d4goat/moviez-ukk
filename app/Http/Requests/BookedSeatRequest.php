<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookedSeatRequest extends FormRequest
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
        return [
            'booking_id' => 'required',
            'seat_id' => 'required|array',
            'seat_id.*' => 'required' 
        ];
    }
}
