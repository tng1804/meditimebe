<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'user'           => [
                'id'    => $this->user->id,
                'name'  => $this->user->name,
                'email' => $this->user->email,
                'role'  => $this->user->role,
            ],
            'specialty'  => $this->specialty,
            'license_number'         => $this->license_number,
            'phone'     => $this->phone,
            'gender'    => $this->gender,
            'date_of_birth'     => $this->date_of_birth,
            'status'    => $this->status,
        ];
    }
}
