<?php

namespace App\Http\Controllers;

use App\Imports\SiswaImport;
use App\Models\DataSiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class datasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = DataSiswa::orderBy('nama_siswa', 'asc')->paginate(10);
        return view('admin.siswa', compact('siswa'));
    }

    public function showImportFrom()
    {
        return view('siswa.import');
    }

    public function import(Request $request)
    {
        // Validasi file
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048'
        ], [
            'file.required' => 'File Excel harus dipilih',
            'file.mimes' => 'File harus berformat Excel (.xlsx, .xls) atau CSV',
            'file.max' => 'Ukuran file maksimal 2MB'
        ]);

        try {
            // Log untuk debugging
            Log::info('Starting Excel import process');
            Log::info('File info: ', [
                'name' => $request->file('file')->getClientOriginalName(),
                'size' => $request->file('file')->getSize(),
                'mime' => $request->file('file')->getMimeType()
            ]);

            // Buat instance import
            $import = new SiswaImport();
            
            // Import file
            Excel::import($import, $request->file('file'));

            // Ambil summary
            $summary = $import->getSummary();
            
            Log::info('Import completed', $summary);

            // Return dengan pesan sukses
            if ($summary['inserted'] > 0) {
                return redirect()->back()->with('success', 
                    "Berhasil import {$summary['inserted']} data siswa. " . 
                    ($summary['skipped'] > 0 ? "Dilewati: {$summary['skipped']} data." : "")
                );
            } else {
                return redirect()->back()->with('warning', 
                    'Tidak ada data yang diimport. Silakan periksa format file Excel Anda.'
                );
            }

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            // Handle validation errors
            $failures = $e->failures();
            $errorMessages = [];
            
            foreach ($failures as $failure) {
                $errorMessages[] = "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            }
            
            Log::error('Validation errors during import:', $errorMessages);
            
            return redirect()->back()->with('error', 
                'Validasi gagal: ' . implode(' | ', array_slice($errorMessages, 0, 3)) . 
                (count($errorMessages) > 3 ? ' dan lainnya...' : '')
            );

        } catch (\Exception $e) {
            Log::error('Import error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return redirect()->back()->with('error', 
                'Gagal import data: ' . $e->getMessage() . '. Silakan periksa format file Excel Anda.'
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_siswa' => 'required|min:2|max:255',
            'nis' => 'required|numeric|unique:data_siswas,nis',
        ], [
            'nama_siswa.required' => 'Nama siswa harus diisi',
            'nama_siswa.min' => 'Nama siswa minimal 2 karakter',
            'nis.required' => 'NIS harus diisi',
            'nis.numeric' => 'NIS harus berupa angka',
            'nis.unique' => 'NIS sudah terdaftar'
        ]);

        try {
            DataSiswa::create([
                'nama_siswa' => $request->nama_siswa,
                'nis' => $request->nis,
            ]);

            return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan!');
        
        } catch (\Exception $e) {
            Log::error('Error creating siswa: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menambahkan data siswa: ' . $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $siswa = DataSiswa::findOrFail($id);
        return view('siswa.edit', compact('siswa'), ['title' => 'Edit Data']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $siswa = DataSiswa::findOrFail($id);
        
        $request->validate([
            'nama_siswa' => 'required|min:2|max:255',
            'nis' => 'required|numeric|unique:data_siswas,nis,' . $siswa->id_siswa . ',id_siswa',
        ], [
            'nama_siswa.required' => 'Nama siswa harus diisi',
            'nama_siswa.min' => 'Nama siswa minimal 2 karakter',
            'nis.required' => 'NIS harus diisi',
            'nis.numeric' => 'NIS harus berupa angka',
            'nis.unique' => 'NIS sudah terdaftar'
        ]);

        try {
            $siswa->update([
                'nama_siswa' => $request->nama_siswa,
                'nis' => $request->nis,
            ]);

            return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui!');

        } catch (\Exception $e) {
            Log::error('Error updating siswa: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui data siswa: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $siswa = DataSiswa::findOrFail($id);
            $siswa->delete();

            return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus!');

        } catch (\Exception $e) {
            Log::error('Error deleting siswa: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus data siswa: ' . $e->getMessage());
        }
    }
}