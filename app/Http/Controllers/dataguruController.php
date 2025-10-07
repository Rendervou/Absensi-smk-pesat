<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class dataguruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guru = User::orderBy('name', 'asc')->paginate(12);
        return view('admin.guru', compact('guru'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input - hanya name dan password
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'password' => 'required|string|min:8',
        ], [
            'name.required' => 'Nama guru harus diisi',
            'name.unique' => 'Nama guru sudah terdaftar',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        // Buat user baru tanpa email (jika kolom email tidak ada di tabel)
        User::create([
            'name' => $validated['name'],
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil ditambahkan!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $guru = User::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:users,name,' . $id,
            'password' => 'nullable|string|min:8',
        ], [
            'name.required' => 'Nama guru harus diisi',
            'name.unique' => 'Nama guru sudah terdaftar',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        // Update nama
        $guru->name = $validated['name'];
        
        // Update password jika diisi
        if ($request->filled('password')) {
            $guru->password = Hash::make($validated['password']);
        }

        $guru->save();

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guru = User::findOrFail($id);
        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus!');
    }
}