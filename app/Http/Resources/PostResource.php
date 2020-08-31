<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'order' => $this->order,
            'excerpt' => $this->excerpt,
            'full_description' => $this->full_description,
            'attachments' => MediaResource::collection($this->whenLoaded('media')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
