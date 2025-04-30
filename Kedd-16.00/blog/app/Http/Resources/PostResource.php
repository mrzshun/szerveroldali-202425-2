<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'text' => $this->text,
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'author' => new UserResource($this->whenLoaded('author')),
            //'categories' => CategoryResource::collection($this->categories),
            //'created_at' => $this->created_at,
            //'updated_at' => $this->updated_at,
        ];
    }
}
