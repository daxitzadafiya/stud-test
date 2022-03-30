<?php

namespace App\Http\Resources;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'age' => $this->age,
            'email' => $this->email,
            'address' => $this->address,
            'dob' => $this->dob,
            'gender' => $this->gender,
            'course_name' => Course::find($this->course_id),
            'user' => User::find($this->user_id),
        ];
    }
}
