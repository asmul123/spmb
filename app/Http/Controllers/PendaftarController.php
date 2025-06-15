<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use App\Models\Kuota;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\IOFactory;

class PendaftarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {        
        $pendaftars = Pendaftar::orderBy('jalur', 'asc')->orderBy('pilihan_diterima', 'asc')->orderBy('skor_akhir', 'asc')->get();

        return view('datapendaftar', [
            'menu' => 'data-spmb',
            'smenu' => 'data-pendaftar',
            'no' => 1,
            'pendaftars' => $pendaftars
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $quotas = Kuota::orderBy('jalur', 'asc')->get();
        $proses = 1;
        $update = 0;
        while($proses != 0){
            $dataupdate = 0;
                foreach($quotas as $quota){
                    if($quota->model_seleksi == 1){
                        $rank_by = 'asc';
                    } else {
                        $rank_by = 'desc';
                    }
                    $pendaftars = Pendaftar::where('jalur', $quota->jalur)->where('pilihan_diterima',$quota->program_keahlian)->orderBy('skor_akhir', $rank_by)->get();
                    $ranking = 1;
                    foreach($pendaftars as $pendaftar){
                        if($ranking <= $quota->kuota_pelimpahan){
                            $pilihan_ke = $pendaftar->pilihan_ke;
                            $pilihan_diterima = $pendaftar->pilihan_diterima;
                            $skor_akhir = $pendaftar->skor_akhir;
                        } else {
                            $pilihan_ke = $pendaftar->pilihan_ke + 1;
                            if($pilihan_ke == 2){
                                $pilihan_diterima = $pendaftar->pilihan_2;
                                $skor_akhir = $pendaftar->skor_pilihan_2;
                            } else {
                                $pilihan_diterima = "Tidak Diterima";
                                $skor_akhir = $pendaftar->skor_akhir;
                            }
                        }
                        if ($pendaftar->pilihan_ke != $pilihan_ke){
                            $data = ([
                                'pilihan_ke' => $pilihan_ke,
                                'pilihan_diterima' => $pilihan_diterima,
                                'skor_akhir' => $skor_akhir
                            ]);
                            Pendaftar::where('id', $pendaftar->id)
                                    ->update($data);
                                    $dataupdate++;
                        }
                        $ranking++;
                        // echo $pendaftar->id."-".$pendaftar->jalur."-".$quota->kuota_pelimpahan."-".$pilihan_ke."-".$pilihan_diterima."<br>";
                    }
                }
            $update++;
            $proses = $dataupdate;
        }
                    
        return redirect()->back()->with('success', $update . ' Proses seleksi telah dilakukan ');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);

        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $i=1;
        $berhasil = 0;
        $gagal = 0;
        foreach ($sheet->getRowIterator() as $row) {
            $no = $sheet->getCell('A'.$i)->getValue();
            if (is_numeric($no)){
                    $nomor_pendaftaran = $sheet->getCell('C'.$i)->getValue();
                    $nisn = $sheet->getCell('D'.$i)->getValue();
                    $nama = $sheet->getCell('E'.$i)->getValue();
                    $asal_sekolah = $sheet->getCell('F'.$i)->getValue();
                    $pil_1 = $sheet->getCell('G'.$i)->getValue();
                    $pil_2 = $sheet->getCell('H'.$i)->getValue();
                    $pil_3 = $sheet->getCell('I'.$i)->getValue();
                    $p_1 = explode(" - ", $pil_1);
                    $p_2 = explode(" - ", $pil_2);
                    $p_3 = explode(" - ", $pil_3);
                    $jalur = $p_1[2];
                    $pilihan_1 = $p_1[1];
                    if($pil_2 != "-"){
                        if($p_2[0] != "SMKN 1 GARUT"){
                            $pilihan_2 = $p_2[0]." - ".$p_2[1];
                        } else {
                            $pilihan_2 = $p_2[1];
                        }
                    } else {
                        $pilihan_2 = "-";
                    }
                    if($pil_3 != "-"){
                        if($p_3[0] != "SMKN 1 GARUT"){
                            $pilihan_3 = $p_3[0]." - ".$p_3[1];
                        } else {
                            $pilihan_3 = $p_3[1];
                        }
                    } else {
                        $pilihan_3 = "-";
                    }
                    $skor_1 = explode (" ",$sheet->getCell('K'.$i)->getValue());
                    $skor_2 = explode (" ",$sheet->getCell('K'.$i+1)->getValue());
                    $skor_3 = explode (" ",$sheet->getCell('K'.$i+2)->getValue());
                    if(count($skor_1) >= 3){
                        if ($p_1[2] =="PERSIAPAN KELAS INDUSTRI"){
                            $skor_pilihan_1 = $skor_1[3];
                        } else {
                            $skor_pilihan_1 = $skor_1[2];
                        }
                    } else {
                        $skor_pilihan_1 = 0;
                    }
                    if(count($skor_2) >= 3){
                        if ($p_1[2] =="PERSIAPAN KELAS INDUSTRI"){
                            $skor_pilihan_2 = $skor_2[3];
                        } else {
                            $skor_pilihan_2 = $skor_2[2];
                        }
                    } else {
                        $skor_pilihan_2 = 0;
                    }
                    if(count($skor_3) >= 3){
                        if ($p_1[2] =="PERSIAPAN KELAS INDUSTRI"){
                            $skor_pilihan_3 = $skor_3[3];
                        } else {
                            $skor_pilihan_3 = $skor_3[2];
                        }
                    } else {
                        $skor_pilihan_3 = 0;
                    }
                    $data = ([
                        'nomor_pendaftaran' => $nomor_pendaftaran,
                        'nisn' => $nisn,
                        'nama' => $nama,
                        'asal_sekolah' => $asal_sekolah,
                        'jalur' => $jalur,
                        'pilihan_1' => $pilihan_1,
                        'skor_pilihan_1' => $skor_pilihan_1,
                        'pilihan_2' => $pilihan_2,
                        'skor_pilihan_2' => $skor_pilihan_2,
                        'pilihan_3' => $pilihan_3,
                        'skor_pilihan_3' => $skor_pilihan_3,
                        'pilihan_ke' => '1',
                        'pilihan_diterima' => $pilihan_1,
                        'skor_akhir' => $skor_pilihan_1
                    ]);
                    $cekNomor = Pendaftar::where('nomor_pendaftaran', $nomor_pendaftaran)->first();
                    if($cekNomor){
                        $gagal++;
                    } else {
                            Pendaftar::create($data);
                            $berhasil++;
                    }
                }
                $i++;                
            }
            
            return redirect()->back()->with('success', $berhasil . ' Pendaftar berhasil disimpan ' . $gagal . ' Pendaftar gagal disimpan');
        }

    /**
     * Display the specified resource.
     */
    public function show(Pendaftar $pendaftar)
    {
        $quotas = Kuota::all();
        $pendaftars = Pendaftar::all();
        if(request('act')=='reset'){
            foreach($pendaftars as $pend){
                $data = ([
                    'pilihan_ke' => 1,
                    'pilihan_diterima' => $pend->pilihan_1,
                    'skor_akhir' => $pend->skor_pilihan_1
                ]);
                Pendaftar::where('id', $pend->id)
                ->update($data);
            }            
            return redirect()->back()->with('success', 'Data Telah di Reset');
        } else if (request('act')=='delete'){
            foreach($quotas as $quota){
                $data = ([
                    'kuota_pelimpahan' => $quota->kuota,
                    'status_pelimpahan' => 0
                ]);
                Kuota::where('id', $quota->id)
                        ->update($data);
            }            
            Pendaftar::truncate();
            return redirect()->back()->with('success', 'Data Telah di Hapus');
        }
        
            
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pendaftar $pendaftar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pendaftar $pendaftar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pendaftar $pendaftar)
    {
        //
    }
}
