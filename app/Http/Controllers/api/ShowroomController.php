<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Showroom; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShowroomController extends Controller
{
    public function index()
    {
        $showrooms = Showroom::all();
        if ($showrooms->count() > 0) {
            return response()->json([
                'status' => true,
                'data' => $showrooms
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Data masih kosong'
            ], 404);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'merek_mobil' => ['required', 'max:255'],
            'nama_mobil' => ['required', 'max:255'],
            'warna_mobil' => ['required', 'max:255'],
        ], [
            'merek_mobil.required' => 'Merek mobil harus diisi',
            'merek_mobil.max' => 'Maksimum 255 karakter',
            'nama_mobil.required' => 'Nama mobil harus diisi',
            'nama_mobil.max' => 'Maksimum 255 karakter',
            'warna_mobil.required' => 'Warna mobil harus diisi',
            'warna_mobil.max' => 'Maksimum 255 karakter',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ], 400);
        }

        $showroom = new Showroom(); // Change 'Showroom' to the appropriate model for 'Showroom' (if it's not Showroom).
        $showroom->merek_mobil = $request->merek_mobil; // Change 'jenis_hewan' to 'merek_mobil'.
        $showroom->nama_mobil = $request->nama_mobil; // Change 'nama_hewan' to 'nama_mobil'.
        $showroom->warna_mobil = $request->warna_mobil; // Change 'harga_rokok' to 'warna_mobil'.
        $simpan = $showroom->save();

        if ($simpan) {
            return response()->json([
                'status' => true,
                'message' => 'Berhasil tambah data mobil di showroom'
            ], 201);
        }
    }

    public function show($id)
    {
        $showroom = Showroom::find($id); // Change 'Showroom' to the appropriate model for 'Showroom' (if it's not Showroom).

        if ($showroom == null) {
            return response()->json([
                'status' => false,
                'message' => 'ID tidak ditemukan'
            ], 404);
        } else {
            return response()->json([
                'status' => true,
                'data' => $showroom
            ], 200);
        }
    }

    public function update(Request $request, $id)
    {
        $showroom = Showroom::find($id); // Change 'Showroom' to the appropriate model for 'Showroom' (if it's not Showroom).

        if ($showroom == null) {
            return response()->json([
                'status' => false,
                'message' => 'ID tidak ditemukan'
            ], 404);
        } else {
            $validator = Validator::make($request->all(), [
                'merek_mobil' => ['required', 'max:255'],
                'nama_mobil' => ['required', 'max:255'],
                'warna_mobil' => ['required', 'max:255'],
            ], [
                'merek_mobil.required' => 'Merek mobil harus diisi',
                'merek_mobil.max' => 'Maksimum 255 karakter',
                'nama_mobil.required' => 'Nama mobil harus diisi',
                'nama_mobil.max' => 'Maksimum 255 karakter',
                'warna_mobil.required' => 'Warna mobil harus diisi',
                'warna_mobil.max' => 'Maksimum 255 karakter',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()
                ], 400);
            }

            $showroom->merek_mobil = $request->merek_mobil; // Change 'jenis_hewan' to 'merek_mobil'.
            $showroom->nama_mobil = $request->nama_mobil; // Change 'nama_hewan' to 'nama_mobil'.
            $showroom->warna_mobil = $request->warna_mobil; // Change 'harga_rokok' to 'warna_mobil'.

            if ($showroom->save()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Data mobil di showroom berhasil di-update'
                ], 200);
            }
        }
    }

    public function destroy($id)
    {
        $showroom = Showroom::find($id); // Change 'Showroom' to the appropriate model for 'Showroom' (if it's not Showroom).
        if ($showroom == null) {
            return response()->json([
                'status' => false,
                'message' => 'ID tidak ditemukan'
            ], 404);
        }

        $delete = $showroom->delete();
        if ($delete) {
            return response()->json([
                'status' => true,
                'message' => 'Data mobil di showroom berhasil dihapus'
            ], 200);
        }
    }
}
