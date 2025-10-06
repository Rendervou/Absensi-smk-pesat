<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:8',
        ], [
            'name.required' => 'Nama guru harus diisi',
            'password.required' => 'Password harus diisi',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        // Generate email otomatis dari nama
        $email = Str::slug($validated['name'], '') . '@guru.com';
        
        // Cek jika email sudah ada, tambahkan angka random
        $counter = 1;
        $originalEmail = $email;
        while (User::where('email', $email)->exists()) {
            $email = str_replace('@guru.com', $counter . '@guru.com', $originalEmail);
            $counter++;
        }

        // Buat user baru
        User::create([
            'name' => $validated['name'],
            'email' => $email,
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.guru')->with('success', 'Data guru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $guru = User::findOrFail($id);

        // Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8',
        ], [
            'name.required' => 'Nama guru harus diisi',
            'password.min' => 'Password minimal 8 karakter',
        ]);

        // Update nama
        $guru->name = $validated['name'];
        
        // Update password jika diisi
        if ($request->filled('password')) {
            $guru->password = Hash::make($validated['password']);
        }

        $guru->save();

        return redirect()->route('admin.guru')->with('success', 'Data guru berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $guru = User::findOrFail($id);
        $guru->delete();

        return redirect()->route('admin.guru')->with('success', 'Data guru berhasil dihapus!');
    }
}