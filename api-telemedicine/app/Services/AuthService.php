<?php

namespace App\Services;

use App\Models\User;
use App\Models\Doctor;
use App\Models\Patient;
use App\Interfaces\AuthServiceInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class AuthService implements AuthServiceInterface
{
  public function register(array $data)
  {
    // Requirement OOP: Encapsulation (Logika transaksi dibungkus di sini)

    return DB::transaction(function () use ($data) {
      // 1. Buat User dasar
      $user = User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password']),
        'role' => $data['role'],
      ]);

      // 2. Cek Role dan isi tabel detail (Polymorphic logic manual)
      if ($data['role'] === 'doctor') {
        Doctor::create([
          'user_id' => $user->id,
          'specialization' => $data['specialization'],
          'license_number' => $data['license_number'],
          'experience_years' => $data['experience_years'],
          'consultation_fee' => $data['consultation_fee'],
        ]);
      } elseif ($data['role'] === 'patient') {
        Patient::create([
          'user_id' => $user->id,
          'date_of_birth' => $data['date_of_birth'],
          'gender' => $data['gender'],
          'address' => $data['address'] ?? null,
        ]);
      }

      // 3. Generate Token Sanctum
      $token = $user->createToken('auth_token')->plainTextToken;

      return [
        'user' => $user,
        'token' => $token
      ];
    });
  }

  public function login(array $credentials)
  {
    if (!Auth::attempt($credentials)) {
      throw ValidationException::withMessages([
        'email' => ['Kredensial yang diberikan salah.'],
      ]);
    }

    $user = User::where('email', $credentials['email'])->first();
    $token = $user->createToken('auth_token')->plainTextToken;

    return [
      'user' => $user,
      'token' => $token
    ];
  }

  public function logout()
  {
    // Hapus token user yang sedang login
    $user = Auth::user();
    if (!$user) {
      return;
    }

    DB::table('personal_access_tokens')
      ->where('tokenable_id', $user->id)
      ->where('tokenable_type', get_class($user))
      ->delete();
  }
}
