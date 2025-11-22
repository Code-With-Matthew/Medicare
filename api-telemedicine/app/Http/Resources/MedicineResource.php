<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MedicineResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      'id' => $this->id,
      'product_name' => $this->name,
      'info' => [
        'category' => $this->category,
        'price_formatted' => 'Rp ' . number_format($this->price, 0, ',', '.'),
        'stock_left' => $this->stock,
      ],
      'description' => $this->description,
    ];
  }
}
