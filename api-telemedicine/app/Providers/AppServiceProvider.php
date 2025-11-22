<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\AuthServiceInterface;
use App\Services\AuthService;
use App\Interfaces\DoctorRepositoryInterface;
use App\Repositories\DoctorRepository;
// ----------------------------

class AppServiceProvider extends ServiceProvider
{
  public function register(): void
  {
    // Binding Auth Service (yang tadi Phase 2)
    $this->app->bind(AuthServiceInterface::class, AuthService::class);

    // --- 2. Tambahkan Binding Repository ini ---
    $this->app->bind(DoctorRepositoryInterface::class, DoctorRepository::class);
  }

  public function boot(): void
  {
    //
  }
}
