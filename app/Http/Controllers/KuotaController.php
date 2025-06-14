<?php

namespace App\Http\Controllers;

use App\Models\Kuota;
use Illuminate\Http\Request;

class KuotaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        $kuotas = Kuota::orderBy('jalur', 'asc')->orderBy('program_keahlian', 'asc')->get();

        return view('datakuota', [
            'menu' => 'data-spmb',
            'smenu' => 'data-kuota',
            'no' => 1,
            'kuotas' => $kuotas
        ]);
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
    public function show(Kuota $kuota)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kuota $kuota)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kuota $kuota)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kuota $kuota)
    {
        //
    }
}
