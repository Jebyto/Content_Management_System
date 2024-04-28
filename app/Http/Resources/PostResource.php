<?php

namespace App\Http\Resources;

use Carbon\Carbon;
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
            'content' => $this->content,
            'created' => Carbon::make($this->created_at)->format('Y-m-d'),
            'user' => new UserResource($this->user),
            'tags' => TagResourceWithoutPosts::collection($this->tags)
        ];
    }
}
