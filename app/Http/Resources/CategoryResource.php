<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $posts = PostResource::collection($this->whenLoaded('posts'));
        $posts = $posts ? $posts : [];

        return [
            'id' => $this->id,
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            'order' => $this->order,
            'count' => count( $posts),
            'posts' => $posts,
            'children' => $this->whenLoaded('children'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
