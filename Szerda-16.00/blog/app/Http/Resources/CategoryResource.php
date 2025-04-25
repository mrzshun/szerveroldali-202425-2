<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *->whenLoaded
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'style' => $this->style,
            'hidden' => $this->hidden,
            'posts' => PostResource::collection($this->whenLoaded('posts')),
        ];
    }
}
