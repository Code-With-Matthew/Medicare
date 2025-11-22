<?php

namespace App\Http\Controllers;

use App\Interfaces\AuthServiceInterface;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class AuthController extends Controller
{
  use ApiResponser; // Menggunakan Trait

  // Requirement OOP: Access Modifier (protected) & Dependency Injection
  protected $authService;

  public function __construct(AuthServiceInterface $authService)
  {
    $this->authService = $authService;
  }

  public function register(Request $request)
  {
    // Validasi sederhana (Nanti bisa dipindah ke FormRequest)
    $request->validate([
      'name' => 'required|string|max:255',
      'email' => 'required|string|email|unique:users',
      'password' => 'required|string|min:8',
      'role' => 'required|in:doctor,patient',
      // Validasi kondisional
      'specialization' => 'required_if:role,doctor',
      'license_number' => 'required_if:role,doctor|unique:doctors',
      'date_of_birth' => 'required_if:role,patient|date',
    ]);

    try {
      $result = $this->authService->register($request->all());
      return $this->successResponse($result, 'Registrasi Berhasil', 201);
    } catch (\Exception $e) {
      return $this->errorResponse($e->getMessage(), 500);
    }
  }

  public function login(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required',
    ]);

    try {
      $result = $this->authService->login($request->only('email', 'password'));
      return $this->successResponse($result, 'Login Berhasil');
    } catch (\Exception $e) {
      return $this->errorResponse($e->getMessage(), 401);
    }
  }

  public function logout()
  {
    $this->authService->logout();
    return $this->successResponse(null, 'Logout Berhasil');
  }
}
