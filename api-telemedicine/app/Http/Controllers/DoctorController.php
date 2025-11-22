<?php

namespace App\Http\Controllers;

use App\Interfaces\DoctorRepositoryInterface;
use App\Traits\ApiResponser; // Pakai Trait buatan kita
use Illuminate\Http\Request;

class DoctorController extends Controller
{
  use ApiResponser;

  // Variabel untuk menyimpan Repository
  private DoctorRepositoryInterface $doctorRepository;

  // CONSTRUCTOR INJECTION (Inti OOP di sini)
  public function __construct(DoctorRepositoryInterface $doctorRepository)
  {
    $this->doctorRepository = $doctorRepository;
  }

  public function index()
  {
    // Controller tidak query DB langsung, tapi minta Repository
    $doctors = $this->doctorRepository->getAllDoctors();
    return $this->successResponse($doctors, 'List Dokter berhasil diambil');
  }

  public function show($id)
  {
    try {
      $doctor = $this->doctorRepository->getDoctorById($id);
      return $this->successResponse($doctor, 'Detail Dokter ditemukan');
    } catch (\Exception $e) {
      return $this->errorResponse('Dokter tidak ditemukan', 404);
    }
  }
}
