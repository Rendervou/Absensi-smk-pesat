<?php

namespace App\Http\Controllers;

use App\Models\DataGuru;
use App\Models\User;
use Illuminate\Http\Request;

class dataguruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guru = User::orderBy('name', 'asc')->paginate(10);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
                $g = DataGuru::findOrFail($id);


        //delete product
        $g->delete();

        //redirect to index
        return redirect()->route('admin.guru')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
