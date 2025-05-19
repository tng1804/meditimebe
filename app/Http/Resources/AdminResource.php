<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AdminResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'role'  => $this->role,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            // 'appointments'   => AppointmentResource::collection($this->whenLoaded('appointments')),
            // 'medicalRecords' => MedicalRecordResource::collection($this->whenLoaded('medicalRecords')),
        ];
    }
}
