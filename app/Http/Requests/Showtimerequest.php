<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Showtimerequest extends FormRequest
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
            'film_id' => 'required',
            'studio_id' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'price' => 'required'
        ];
    }

    protected function prepareForValidation() {
        $price = str_replace('.', '', $this->price);
        $price = str_replace(',', '.', $price);

        $this->merge([
            'price' => $price,
        ]);
    }
}
