<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class TodoController extends Controller
{
    /**
     * Menampilkan semua todo milik user yang login
     */
    public function index()
    {
        // Ambil user ID dari token
        $todos = Todo::where('user_id', auth()->id())->latest()->get();

        return response()->json([
            'status' => 'success',
            'data'   => $todos
        ]);
    }

    /**
     * Membuat Todo baru
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        // 2. Return Error JSON jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation Error',
                'errors'  => $validator->errors()
            ], 422);
        }

        // 3. Create Data
        $todo = Todo::create([
            'title'       => $request->title,
            'description' => $request->description,
            'user_id'     => auth()->id() // Ambil ID otomatis dari token
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Todo created successfully',
            'data'    => $todo
        ], 201);
    }

    /**
     * Update Todo
     */
    public function update(Request $request, $id)
    {
        // 1. Cari Todo milik user (Manual Check untuk 404 JSON)
        $todo = Todo::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$todo) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Todo not found or access denied'
            ], 404);
        }

        // 2. Validasi Input (Gunakan 'sometimes' agar user bisa update salah satu field saja)
        $validator = Validator::make($request->all(), [
            'title'       => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'is_done'     => 'boolean' // Validasi untuk status selesai
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Validation Error',
                'errors'  => $validator->errors()
            ], 422);
        }

        // 3. Update Data
        $todo->update($request->all());

        return response()->json([
            'status'  => 'success',
            'message' => 'Todo updated successfully',
            'data'    => $todo
        ]);
    }

    /**
     * Hapus Todo
     */
    public function destroy($id)
    {
        // 1. Cari Todo milik user
        $todo = Todo::where('id', $id)->where('user_id', auth()->id())->first();

        if (!$todo) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Todo not found or access denied'
            ], 404);
        }

        // 2. Hapus
        $todo->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Todo deleted successfully'
        ]);
    }
}