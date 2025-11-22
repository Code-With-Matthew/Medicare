<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicineRequest extends FormRequest
{
  public function authorize(): bool
  {
    return true;
  }

  public function rules(): array
  {
    return [
      'name' => 'sometimes|string|max:255',
      'category' => 'sometimes|string',
      'stock' => 'sometimes|integer|min:0',
      'price' => 'sometimes|numeric|min:0',
      'description' => 'nullable|string'
    ];
  }
}
