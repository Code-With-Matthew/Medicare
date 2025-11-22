<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
  use HasFactory;

  protected $fillable = [
    'appointment_id',
    'doctor_id',
    'patient_id',
    'diagnosis',
    'treatment_plan',
  ];

  public function appointment()
  {
    return $this->belongsTo(Appointment::class);
  }

  // --- TAMBAHKAN DUA FUNGSI INI ---

  public function doctor()
  {
    return $this->belongsTo(Doctor::class);
  }

  public function patient()
  {
    return $this->belongsTo(Patient::class);
  }
}
