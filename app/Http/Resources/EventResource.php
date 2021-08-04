<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class EventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $url = url("/image/{$this->image}");
        return [
            'id' => $this->id,
            'name' => $this->name,
            'address' => $this->address,
            'user' => new UserResource($this->user),
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'image' => $url,
            'category' => $this->category->name,
        ];
    }
}
