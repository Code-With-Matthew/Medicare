<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMedicineRequest;
use App\Http\Requests\UpdateMedicineRequest;
use App\Http\Resources\MedicineResource;
use App\Traits\ApiResponser; // Jangan lupa Trait kita

class MedicineController extends Controller
{
    use ApiResponser;

    // READ (Get All)
    public function index()
    {
        $medicines = Medicine::all();
        // Bungkus collection dengan resource
        return $this->successResponse(
            MedicineResource::collection($medicines), 
            'Data obat berhasil diambil'
        );
    }

    // CREATE (Post)
    // Perhatikan: Type Hint menggunakan StoreMedicineRequest
    public function store(StoreMedicineRequest $request)
    {
        // Validasi sudah otomatis jalan di background oleh Laravel
        $medicine = Medicine::create($request->validated());

        return $this->successResponse(
            new MedicineResource($medicine),
            'Obat berhasil ditambahkan',
            201
        );
    }

    // READ (Get One)
    public function show($id)
    {
        $medicine = Medicine::find($id);
        if (!$medicine) return $this->errorResponse('Obat tidak ditemukan', 404);

        return $this->successResponse(new MedicineResource($medicine), 'Detail obat ditemukan');
    }

    // UPDATE (Put/Patch)
    public function update(UpdateMedicineRequest $request, $id)
    {
        $medicine = Medicine::find($id);
        if (!$medicine) return $this->errorResponse('Obat tidak ditemukan', 404);

        // Update data
        $medicine->update($request->validated());

        return $this->successResponse(
            new MedicineResource($medicine),
            'Data obat berhasil diperbarui'
        );
    }

    // DELETE (Delete)
    public function destroy($id)
    {
        $medicine = Medicine::find($id);
        if (!$medicine) return $this->errorResponse('Obat tidak ditemukan', 404);

        $medicine->delete();

        return $this->successResponse(null, 'Obat berhasil dihapus');
    }
}