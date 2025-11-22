<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicineRequest extends FormRequest
{
  public function authorize(): bool
  {
    // Ubah jadi true (nanti bisa dicek apakah user admin/dokter)
    return true;
  }

  public function rules(): array
  {
    return [
      'name' => 'required|string|max:255',
      'category' => 'required|string',
      'stock' => 'required|integer|min:0',
      'price' => 'required|numeric|min:0',
      'description' => 'nullable|string'
    ];
  }
}
