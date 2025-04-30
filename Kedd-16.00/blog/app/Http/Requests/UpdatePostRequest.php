<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $post = Post::findOrFail($this->route('id'));
        return $this->user()->tokenCan('blog:admin') || $post->author->id == $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'                 => 'required|min:4|max:10',
            'description'           => 'nullable',
            'text'                  => 'required',
            'categories'            => 'nullable|array',
            'categories.*'          => 'numeric|integer|exists:categories,id',
            // 'cover_image'           => 'file|mimes:jpg,png|max:4096',
            // 'remove_cover_image'    => 'nullable|boolean',
        ];
    }
}
