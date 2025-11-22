<?php

namespace App\Interfaces;

interface DoctorRepositoryInterface
{
  // Kontrak: Siapapun yang pakai interface ini WAJIB punya fungsi-fungsi ini
  public function getAllDoctors();
  public function getDoctorById($id);
  public function updateDoctor($id, array $newDetails);
}
