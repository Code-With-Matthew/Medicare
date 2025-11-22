<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
  use HasFactory;

  protected $fillable = [
    'doctor_id',
    'patient_id',
    'appointment_date',
    'status', // 'scheduled', 'completed', 'cancelled'
    'notes',
  ];

  // Relasi: Satu janji temu milik satu Dokter
  public function doctor()
  {
    return $this->belongsTo(Doctor::class);
  }

  // Relasi: Satu janji temu milik satu Pasien
  public function patient()
  {
    return $this->belongsTo(Patient::class);
  }

  // Relasi: Satu janji temu bisa punya satu Rekam Medis (nanti)
  public function medicalRecord()
  {
    return $this->hasOne(MedicalRecord::class);
  }
}
