<?php

namespace App\Http\Controllers;

use App\Models\Kuota;
use App\Models\Program;
use App\Models\Pendaftar;
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
        $programs = Program::all();
        $melimpah = 0;
        foreach($programs as $program){
            $kuota_mutasi = Kuota::where('jalur', 'MUTASI')->where('program_keahlian', $program->program_keahlian)->first();
            $kuota_pelimpahan_mutasi = $kuota_mutasi->kuota_pelimpahan;
            $pendaftar_mutasi = Pendaftar::where('jalur', 'MUTASI')->where('pilihan_diterima', $program->program_keahlian)->count();
            if($kuota_pelimpahan_mutasi > $pendaftar_mutasi){
                $status_kuota_mutasi = "lebih";
                $kelebihan_kuota_mutasi = $kuota_pelimpahan_mutasi - $pendaftar_mutasi;
            } else {
                $cek_pendaftar_tidakditerima_mutasi = Pendaftar::where('jalur', 'MUTASI')->where('pilihan_diterima', '<>', $program->program_keahlian)
                                                ->where('pilihan_1',$program->program_keahlian)->orwhere('pilihan_2',$program->program_keahlian)->where('jalur', 'MUTASI')->where('pilihan_diterima', 'Tidak Diterima')->count();
                if($cek_pendaftar_tidakditerima_mutasi == 0){
                $status_kuota_mutasi = "pas";
                } else {
                $status_kuota_mutasi = "kurang";
                }
            }
            $kuota_anakguru = Kuota::where('jalur', 'ANAK GURU')->where('program_keahlian', $program->program_keahlian)->first();
            $kuota_pelimpahan_anakguru = $kuota_anakguru->kuota_pelimpahan;
            $pendaftar_anakguru = Pendaftar::where('jalur', 'ANAK GURU')->where('pilihan_diterima', $program->program_keahlian)->count();
            if($kuota_pelimpahan_anakguru > $pendaftar_anakguru){
                $status_kuota_anakguru = "lebih";
                $kelebihan_kuota_anakguru = $kuota_pelimpahan_anakguru - $pendaftar_anakguru;
            } else {
                $cek_pendaftar_tidakditerima_anakguru = Pendaftar::where('jalur', 'ANAK GURU')->where('pilihan_diterima', '<>', $program->program_keahlian)
                                                ->where('pilihan_1',$program->program_keahlian)->orwhere('pilihan_2',$program->program_keahlian)->where('jalur', 'ANAK GURU')->where('pilihan_diterima', 'Tidak Diterima')->count();
                
                if($cek_pendaftar_tidakditerima_anakguru == 0){
                $status_kuota_anakguru = "pas";
                } else {
                $status_kuota_anakguru = "kurang";
                }
            }
            $kuota_domisili = Kuota::where('jalur', 'DOMISILI TERDEKAT')->where('program_keahlian', $program->program_keahlian)->first();
            $kuota_pelimpahan_domisili = $kuota_domisili->kuota_pelimpahan;
            $pendaftar_domisili = Pendaftar::where('jalur', 'DOMISILI TERDEKAT')->where('pilihan_diterima', $program->program_keahlian)->count();
            if($kuota_pelimpahan_domisili > $pendaftar_domisili){
                $status_kuota_domisili = "lebih";
                $kelebihan_kuota_domisili = $kuota_pelimpahan_domisili - $pendaftar_domisili;                
            } else {
                $cek_pendaftar_tidakditerima_domisili = Pendaftar::where('jalur', 'DOMISILI TERDEKAT')->where('pilihan_diterima', '<>', $program->program_keahlian)
                                                ->where('pilihan_1',$program->program_keahlian)->orwhere('pilihan_2',$program->program_keahlian)->where('jalur', 'DOMISILI TERDEKAT')->where('pilihan_diterima', 'Tidak Diterima')->count();
                if($cek_pendaftar_tidakditerima_domisili == 0){
                $status_kuota_domisili = "pas";
                } else {
                $status_kuota_domisili = "kurang";
                }
            }
            if ($status_kuota_mutasi == "lebih"){
                if($status_kuota_anakguru == "lebih"){
                    if($status_kuota_domisili == "kurang"){
                        $kuota_dilimpahkan = $kelebihan_kuota_mutasi + $kelebihan_kuota_anakguru + $kuota_pelimpahan_domisili;
                        $data = ([
                            'kuota_pelimpahan' => $kuota_dilimpahkan,
                            'status_pelimpahan' => 1
                        ]);
                        Kuota::where('id', $kuota_domisili->id)
                                ->update($data);
                        $data = ([
                            'kuota_pelimpahan' => $pendaftar_mutasi,
                            'status_pelimpahan' => 2
                        ]);
                        Kuota::where('id', $kuota_mutasi->id)
                                ->update($data);
                                $data = ([
                            'kuota_pelimpahan' => $pendaftar_anakguru,
                            'status_pelimpahan' => 2
                        ]);
                        Kuota::where('id', $kuota_anakguru->id)
                                ->update($data);
                        $melimpah++;
                    }
                } else if($status_kuota_domisili == "lebih") {
                    if($status_kuota_anakguru == "kurang"){
                        $kuota_dilimpahkan = $kelebihan_kuota_mutasi + $kelebihan_kuota_domisili + $kuota_pelimpahan_anakguru;
                        $data = ([
                            'kuota_pelimpahan' => $kuota_dilimpahkan,
                            'status_pelimpahan' => 1
                        ]);
                        Kuota::where('id', $kuota_anakguru->id)
                                ->update($data);
                        $data = ([
                            'kuota_pelimpahan' => $pendaftar_mutasi,
                            'status_pelimpahan' => 2
                        ]);
                        Kuota::where('id', $kuota_mutasi->id)
                                ->update($data);
                        $data = ([
                            'kuota_pelimpahan' => $pendaftar_domisili,
                            'status_pelimpahan' => 2
                        ]);
                        Kuota::where('id', $kuota_domisili->id)
                                ->update($data);
                                $melimpah++;;
                    }
                } else if($status_kuota_anakguru == "kurang"){
                    $kuota_dilimpahkan = $kelebihan_kuota_mutasi + $kuota_pelimpahan_anakguru;
                    $data = ([
                        'kuota_pelimpahan' => $kuota_dilimpahkan,
                        'status_pelimpahan' => 1
                    ]);
                    Kuota::where('id', $kuota_anakguru->id)
                    ->update($data);
                    $data = ([
                        'kuota_pelimpahan' => $pendaftar_mutasi,
                        'status_pelimpahan' => 2
                    ]);
                    Kuota::where('id', $kuota_mutasi->id)
                            ->update($data);
                            $melimpah++;;                        
                }
            } else if ($status_kuota_anakguru == "lebih"){
                if($status_kuota_mutasi == "kurang"){
                    $kuota_dilimpahkan = $kelebihan_kuota_anakguru + $kuota_pelimpahan_mutasi;
                    $data = ([
                        'kuota_pelimpahan' => $kuota_dilimpahkan,
                        'status_pelimpahan' => 1
                    ]);
                    Kuota::where('id', $kuota_mutasi->id)
                    ->update($data);
                    $data = ([
                        'kuota_pelimpahan' => $pendaftar_anakguru,
                        'status_pelimpahan' => 2
                    ]);
                    Kuota::where('id', $kuota_anakguru->id)
                            ->update($data);
                            $melimpah++;;  
                } else if ($status_kuota_domisili == "kurang"){
                    $kuota_dilimpahkan = $kelebihan_kuota_anakguru + $kuota_pelimpahan_domisili;
                    $data = ([
                        'kuota_pelimpahan' => $kuota_dilimpahkan,
                        'status_pelimpahan' => 1
                    ]);
                    Kuota::where('id', $kuota_domisili->id)
                    ->update($data);
                    $data = ([
                        'kuota_pelimpahan' => $pendaftar_anakguru,
                        'status_pelimpahan' => 2
                    ]);
                    Kuota::where('id', $kuota_anakguru->id)
                            ->update($data);
                            $melimpah++;;  
                }
            }

            $kuota_mbk = Kuota::where('jalur', 'MURID BERKEBUTUHAN KHUSUS')->where('program_keahlian', $program->program_keahlian)->first();
            $kuota_pelimpahan_mbk = $kuota_mbk->kuota_pelimpahan;
            $pendaftar_mbk = Pendaftar::where('jalur', 'MURID BERKEBUTUHAN KHUSUS')->where('pilihan_diterima', $program->program_keahlian)->count();
            if($kuota_pelimpahan_mbk > $pendaftar_mbk){
                $status_kuota_mbk = "lebih";
                $kelebihan_kuota_mbk = $kuota_pelimpahan_mbk - $pendaftar_mbk;
            } else {
                $status_kuota_mbk = "kurang";
            }

            $kuota_ketm = Kuota::where('jalur', 'KETM')->where('program_keahlian', $program->program_keahlian)->first();
            $kuota_pelimpahan_ketm = $kuota_ketm->kuota_pelimpahan;
            $pendaftar_ketm = Pendaftar::where('jalur', 'KETM')->where('pilihan_diterima', $program->program_keahlian)->count();
            if($kuota_pelimpahan_ketm > $pendaftar_ketm){
                $status_kuota_ketm = "lebih";
                $kelebihan_kuota_ketm = $kuota_pelimpahan_ketm - $pendaftar_ketm;
            } else {
                $status_kuota_ketm = "kurang";
            }

            if ($status_kuota_mbk == "lebih" and $status_kuota_ketm == "kurang"){
                $kuota_dilimpahkan = $kelebihan_kuota_mbk + $kuota_pelimpahan_ketm;
                    $data = ([
                        'kuota_pelimpahan' => $kuota_dilimpahkan,
                        'status_pelimpahan' => 1
                    ]);
                    Kuota::where('id', $kuota_ketm->id)
                    ->update($data);
                    $data = ([
                        'kuota_pelimpahan' => $pendaftar_mbk,
                        'status_pelimpahan' => 2
                    ]);
                    Kuota::where('id', $kuota_mbk->id)
                            ->update($data);
                            $melimpah++;;
            } else if ($status_kuota_ketm == "lebih" and $status_kuota_mbk == "kurang"){
                $kuota_dilimpahkan = $kelebihan_kuota_ketm + $kuota_pelimpahan_mbk;
                    $data = ([
                        'kuota_pelimpahan' => $kuota_dilimpahkan,
                        'status_pelimpahan' => 1
                    ]);
                    Kuota::where('id', $kuota_mbk->id)
                    ->update($data);
                    $data = ([
                        'kuota_pelimpahan' => $pendaftar_ketm,
                        'status_pelimpahan' => 2
                    ]);
                    Kuota::where('id', $kuota_ketm->id)
                            ->update($data);
                            $melimpah++;;
            }
        }
        echo $melimpah." Kuota terlimpah";

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
        $quotas = Kuota::all();
            foreach($quotas as $quota){
                $data = ([
                    'kuota_pelimpahan' => $quota->kuota,
                    'status_pelimpahan' => 0
                ]);
                Kuota::where('id', $quota->id)
                        ->update($data);
            }            
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
