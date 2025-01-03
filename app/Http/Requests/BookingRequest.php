<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
            'tanggal' => 'required',
            'quantity' => 'required|numeric',
            'user_id' => 'required',
            'total_price' => 'required',
            'invoice_number' => 'nullable',
            'show_time_id' => 'required',
            'promotion_id' => 'nullable',
        ];
    }
}
