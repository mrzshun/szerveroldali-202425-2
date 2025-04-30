<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'title'         => 'required|min:4|max:10',
            'description'   => 'nullable',
            'text'          => 'required',
            'categories'    => 'nullable|array',
            'categories.*'  => 'numeric|integer|exists:categories,id',
            // 'cover_image'   => 'file|mimes:jpg,png|max:4096',
        ];
    }
}
