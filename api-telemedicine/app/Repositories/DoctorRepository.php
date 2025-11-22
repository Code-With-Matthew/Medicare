<?php

namespace App\Repositories;

use App\Interfaces\DoctorRepositoryInterface;
use App\Models\Doctor;

class DoctorRepository implements DoctorRepositoryInterface
{
  public function getAllDoctors()
  {
    // Mengambil data dokter + data usernya (nama, email)
    return Doctor::with('user')->where('is_active', true)->get();
  }

  public function getDoctorById($id)
  {
    return Doctor::with('user')->findOrFail($id);
  }

  public function updateDoctor($id, array $newDetails)
  {
    $doctor = Doctor::findOrFail($id);
    $doctor->update($newDetails);
    return $doctor;
  }
}
