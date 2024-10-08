<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FilmRequest extends FormRequest
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
            'title' => 'required|string',
            'description' => 'required|string',
            'duration' => 'required|numeric',
            'producer' => 'required|string',
            'director' => 'required|string',
            'writer' => 'required|string',
            'poster' => 'required|file|mimes:jpg,png,jpeg',
            'trailer' => 'required|string',
            'release_date' => 'required|date',
        ];
    }
}
