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
        // a user admin vagy pedig a postnak van szerzője és az az authentikált felhasználó
        return $this->user()->tokenCan('admin') || ($post->author != null && $post->author->id == $this->user()->id);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'         => 'required|min:5|max:256',
            'description'   => 'nullable',
            'text'          => 'required',
            'categories'    => 'nullable|array',
            'categories.*'  => 'numeric|integer|exists:categories,id',
            'cover_image'   => 'nullable|file|mimes:jpg,bmp,png|max:4096'
        ];
    }
}
