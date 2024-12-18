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
            'id' => $this->id,
            'name' => $this->user->name,
            'specialization' => $this->specialization,
            'bio' => $this->bio,
            'clinic_address' => $this->clinic_address,
            'available' => $this->is_available,  // Add this line to check if the doctor is available
        ];
    }
}
