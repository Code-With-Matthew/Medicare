<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
  use ApiResponser;

  // GET: Melihat daftar janji temu
  public function index()
  {
    $user = Auth::user();

    if ($user->role === 'patient') {
      // Jika Pasien: Lihat janji temu saya sendiri
      $appointments = Appointment::with('doctor.user')
        ->where('patient_id', $user->patient->id)
        ->get();
    } elseif ($user->role === 'doctor') {
      // Jika Dokter: Lihat pasien yang janji sama saya
      $appointments = Appointment::with('patient.user')
        ->where('doctor_id', $user->doctor->id)
        ->get();
    } else {
      return $this->errorResponse('Role tidak valid', 403);
    }

    return $this->successResponse($appointments, 'Data Janji Temu berhasil diambil');
  }

  // POST: Membuat janji temu (Khusus Pasien)
  public function store(Request $request)
  {
    $request->validate([
      'doctor_id' => 'required|exists:doctors,id',
      'appointment_date' => 'required|date|after:now',
      'notes' => 'nullable|string'
    ]);

    $user = Auth::user();

    // Validasi: Hanya pasien yang boleh buat janji
    if ($user->role !== 'patient') {
      return $this->errorResponse('Hanya pasien yang bisa membuat janji temu', 403);
    }

    // Buat Data Appointment
    $appointment = Appointment::create([
      'patient_id' => $user->patient->id, // Ambil ID pasien dari user yang login
      'doctor_id' => $request->doctor_id,
      'appointment_date' => $request->appointment_date,
      'status' => 'scheduled',
      'notes' => $request->notes
    ]);

    return $this->successResponse($appointment, 'Janji temu berhasil dibuat', 201);
  }
}
