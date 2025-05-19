<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
            'date_of_birth'  => $this->date_of_birth,
            'gender'         => $this->gender,
            'phone'          => $this->phone,
            'address'        => $this->address,
            // 'appointments'   => AppointmentResource::collection($this->whenLoaded('appointments')),
            // 'medicalRecords' => MedicalRecordResource::collection($this->whenLoaded('medicalRecords')),
        ];
    }
}
