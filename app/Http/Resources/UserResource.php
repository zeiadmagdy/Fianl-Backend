<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'profile_image' => $this->profile_image,
            'location' => $this->location,
            'gender' => $this->gender,
            'bio' => $this->bio,
            'birth_date' => !empty($this->birth_date) ?
                Carbon::parse($this->birth_date)->format('d/m/Y') :
                null,
        ];
    }
}
