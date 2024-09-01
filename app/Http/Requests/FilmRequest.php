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
            'title' => ['required|string|max:255'],
            'description' => ['required|string'],
            'duration' => ['required|numeric'],
            'genre' => ['required|string'],
            'poster' => ['required|string'],
            'trailer' => ['required|file|mimes:mp4'],
            'release_date' => ['required|date'],
        ];
    }
}
