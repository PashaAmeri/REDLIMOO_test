<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
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
            'user' => [
                'id' => $this->user_id,
                'name' => $this->publisher->name,
            ],
            'content' => $this->content,
            'replys' => CommentResource::collection($this->allReplys) ?? null,
        ];
    }
}
