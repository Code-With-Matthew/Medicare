<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicalRecordResource extends JsonResource
{
  public function toArray(Request $request): array
  {
    // Kita tentukan field apa saja yang boleh dilihat di JSON Response
    return [
      'record_id' => $this->id,
      'diagnosis' => $this->diagnosis,
      'treatment' => $this->treatment_plan,
      'doctor_info' => [
        'name' => $this->doctor->user->name, // Mengambil nama dari relasi user
        'specialization' => $this->doctor->specialization,
      ],
      'patient_info' => [
        'name' => $this->patient->user->name,
        'gender' => $this->patient->gender,
      ],
      'date' => $this->created_at->format('Y-m-d H:i'), // Format tanggal cantik
    ];
  }
}
