<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Doctor extends Model
{
  use HasFactory;

  // --- TAMBAHKAN KODE INI ---
  protected $fillable = [
    'user_id',
    'specialization',
    'license_number',
    'experience_years',
    'consultation_fee',
    'is_active'
  ];
  // --------------------------

  public function user()
  {
    return $this->belongsTo(User::class);
  }
}
