<?php

namespace App\Http\Controllers;

use App\Http\Resources\MedicalRecordResource;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MedicalRecordController extends Controller
{
  use ApiResponser;

  public function store(Request $request)
  {
    // 1. Validasi Input
    $request->validate([
      'appointment_id' => 'required|exists:appointments,id',
      'diagnosis' => 'required|string',
      'treatment_plan' => 'required|string',
    ]);

    $user = Auth::user();

    // 2. Cek Role: Harus Dokter
    if ($user->role !== 'doctor') {
      return $this->errorResponse('Hanya dokter yang boleh mengisi rekam medis', 403);
    }

    // 3. Ambil Data Appointment
    $appointment = Appointment::find($request->appointment_id);

    // 4. TANTANGAN OOP (Enkapsulasi & Otorisasi):
    // Pastikan dokter yang login ADALAH dokter yang ada di appointment tersebut
    if ($appointment->doctor_id !== $user->doctor->id) {
      return $this->errorResponse('Anda tidak memiliki akses untuk menangani pasien ini', 403);
    }

    // 5. Simpan Data (Gunakan Transaksi agar aman)
    $record = DB::transaction(function () use ($request, $appointment, $user) {
      // Update status appointment jadi 'completed'
      $appointment->update(['status' => 'completed']);

      // Buat Medical Record
      return MedicalRecord::create([
        'appointment_id' => $appointment->id,
        'doctor_id' => $user->doctor->id,
        'patient_id' => $appointment->patient_id,
        'diagnosis' => $request->diagnosis,
        'treatment_plan' => $request->treatment_plan,
      ]);
    });
    $record->load(['doctor.user', 'patient.user']);

    return $this->successResponse(
      new MedicalRecordResource($record),
      'Rekam medis berhasil disimpan',
      201
    );
  }
}
