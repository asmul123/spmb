<?php

namespace App\Http\Controllers;

use App\Models\Pendaftar;
use App\Models\Program;
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
        $pendaftars = Pendaftar::orderBy('jalur', 'asc')->orderBy('pilihan_diterima', 'asc')->orderBy('skor_akhir', 'desc')->get();

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
        $pelimpahan = 1;
        while($pelimpahan != 0){
            $pendaftars = Pendaftar::all();
            foreach($pendaftars as $pend){
                $data = ([
                    'pilihan_ke' => 1,
                    'pilihan_diterima' => $pend->pilihan_1,
                    'skor_akhir' => $pend->skor_pilihan_1
                ]);
                Pendaftar::where('id', $pend->id)
                ->update($data);
            }        
            $quotas = Kuota::orderBy('jalur', 'asc')->get();
            $proses = 1;
            $update = 0;
            $updatepelimpahan = 0;
            while($proses != 0){
                $dataupdate = 0;
                    foreach($quotas as $quota){
                        if($quota->model_seleksi == 1){
                            $rank_by = 'asc';
                        } else {
                            $rank_by = 'desc';
                        }
                        $pendaftars = Pendaftar::where('jalur', $quota->jalur)->where('pilihan_diterima',$quota->program_keahlian)->orderBy('skor_akhir', $rank_by)->orderBy('tanggal_lahir', 'asc')->get();
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
            $programs = Program::all();
            $melimpah = 0;
            foreach($programs as $program){
                // $kuota_mutasi = Kuota::where('jalur', 'MUTASI')->where('program_keahlian', $program->program_keahlian)->first();
                // $kuota_pelimpahan_mutasi = $kuota_mutasi->kuota_pelimpahan;
                // $pendaftar_mutasi = Pendaftar::where('jalur', 'MUTASI')->where('pilihan_diterima', $program->program_keahlian)->count();
                // if($kuota_pelimpahan_mutasi > $pendaftar_mutasi){
                //     $status_kuota_mutasi = "lebih";
                //     $kelebihan_kuota_mutasi = $kuota_pelimpahan_mutasi - $pendaftar_mutasi;
                // } else {
                //     $cek_pendaftar_tidakditerima_mutasi = Pendaftar::where('jalur', 'MUTASI')->where('pilihan_diterima', '<>', $program->program_keahlian)
                //                                     ->where('pilihan_1',$program->program_keahlian)->orwhere('pilihan_2',$program->program_keahlian)->where('jalur', 'MUTASI')->where('pilihan_diterima', 'Tidak Diterima')->count();
                //     if($cek_pendaftar_tidakditerima_mutasi == 0){
                //     $status_kuota_mutasi = "pas";
                //     } else {
                //     $status_kuota_mutasi = "kurang";
                //     }
                // }
                // $kuota_anakguru = Kuota::where('jalur', 'ANAK GURU')->where('program_keahlian', $program->program_keahlian)->first();
                // $kuota_pelimpahan_anakguru = $kuota_anakguru->kuota_pelimpahan;
                // $pendaftar_anakguru = Pendaftar::where('jalur', 'ANAK GURU')->where('pilihan_diterima', $program->program_keahlian)->count();
                // if($kuota_pelimpahan_anakguru > $pendaftar_anakguru){
                //     $status_kuota_anakguru = "lebih";
                //     $kelebihan_kuota_anakguru = $kuota_pelimpahan_anakguru - $pendaftar_anakguru;
                // } else {
                //     $cek_pendaftar_tidakditerima_anakguru = Pendaftar::where('jalur', 'ANAK GURU')->where('pilihan_diterima', '<>', $program->program_keahlian)
                //     ->where('pilihan_1',$program->program_keahlian)->orwhere('pilihan_2',$program->program_keahlian)->where('jalur', 'ANAK GURU')->where('pilihan_diterima', 'Tidak Diterima')->count();
                    
                //     if($cek_pendaftar_tidakditerima_anakguru == 0){
                //         $status_kuota_anakguru = "pas";
                //         $kelebihan_kuota_anakguru = 0;
                //     } else {
                //     $status_kuota_anakguru = "kurang";
                //     }
                // }
                // $kuota_domisili = Kuota::where('jalur', 'DOMISILI TERDEKAT')->where('program_keahlian', $program->program_keahlian)->first();
                // $kuota_pelimpahan_domisili = $kuota_domisili->kuota_pelimpahan;
                // $pendaftar_domisili = Pendaftar::where('jalur', 'DOMISILI TERDEKAT')->where('pilihan_diterima', $program->program_keahlian)->count();
                // if($kuota_pelimpahan_domisili > $pendaftar_domisili){
                //     $status_kuota_domisili = "lebih";
                //     $kelebihan_kuota_domisili = $kuota_pelimpahan_domisili - $pendaftar_domisili;                
                // } else {
                //     $cek_pendaftar_tidakditerima_domisili = Pendaftar::where('jalur', 'DOMISILI TERDEKAT')->where('pilihan_diterima', '<>', $program->program_keahlian)
                //                                     ->where('pilihan_1',$program->program_keahlian)->orwhere('pilihan_2',$program->program_keahlian)->where('jalur', 'DOMISILI TERDEKAT')->where('pilihan_diterima', 'Tidak Diterima')->count();
                //     if($cek_pendaftar_tidakditerima_domisili == 0){
                //     $status_kuota_domisili = "pas";
                //     } else {
                //     $status_kuota_domisili = "kurang";
                //     }
                // }
                // if ($status_kuota_mutasi == "lebih"){
                //     if($status_kuota_anakguru == "lebih" or $status_kuota_anakguru == "pas"){
                //         if($status_kuota_domisili == "kurang"){
                //             $kuota_dilimpahkan = $kelebihan_kuota_mutasi + $kelebihan_kuota_anakguru + $kuota_pelimpahan_domisili;
                //             $data = ([
                //                 'kuota_pelimpahan' => $kuota_dilimpahkan,
                //                 'status_pelimpahan' => 1
                //             ]);
                //             Kuota::where('id', $kuota_domisili->id)
                //                     ->update($data);
                //             $data = ([
                //                 'kuota_pelimpahan' => $pendaftar_mutasi,
                //                 'status_pelimpahan' => 2
                //             ]);
                //             Kuota::where('id', $kuota_mutasi->id)
                //                     ->update($data);
                //                     $data = ([
                //                 'kuota_pelimpahan' => $pendaftar_anakguru,
                //                 'status_pelimpahan' => 2
                //             ]);
                //             Kuota::where('id', $kuota_anakguru->id)
                //                     ->update($data);
                //             $melimpah++;
                //         }
                //     } else if($status_kuota_domisili == "lebih") {
                //         if($status_kuota_anakguru == "kurang"){
                //             $kuota_dilimpahkan = $kelebihan_kuota_mutasi + $kelebihan_kuota_domisili + $kuota_pelimpahan_anakguru;
                //             $data = ([
                //                 'kuota_pelimpahan' => $kuota_dilimpahkan,
                //                 'status_pelimpahan' => 1
                //             ]);
                //             Kuota::where('id', $kuota_anakguru->id)
                //                     ->update($data);
                //             $data = ([
                //                 'kuota_pelimpahan' => $pendaftar_mutasi,
                //                 'status_pelimpahan' => 2
                //             ]);
                //             Kuota::where('id', $kuota_mutasi->id)
                //                     ->update($data);
                //             $data = ([
                //                 'kuota_pelimpahan' => $pendaftar_domisili,
                //                 'status_pelimpahan' => 2
                //             ]);
                //             Kuota::where('id', $kuota_domisili->id)
                //                     ->update($data);
                //                     $melimpah++;;
                //         }
                //     } else if($status_kuota_anakguru == "kurang"){
                //         $kuota_dilimpahkan = $kelebihan_kuota_mutasi + $kuota_pelimpahan_anakguru;
                //         $data = ([
                //             'kuota_pelimpahan' => $kuota_dilimpahkan,
                //             'status_pelimpahan' => 1
                //         ]);
                //         Kuota::where('id', $kuota_anakguru->id)
                //         ->update($data);
                //         $data = ([
                //             'kuota_pelimpahan' => $pendaftar_mutasi,
                //             'status_pelimpahan' => 2
                //         ]);
                //         Kuota::where('id', $kuota_mutasi->id)
                //                 ->update($data);
                //                 $melimpah++;;                        
                //     }
                // } else if ($status_kuota_anakguru == "lebih"){
                //     if($status_kuota_mutasi == "kurang"){
                //         $kuota_dilimpahkan = $kelebihan_kuota_anakguru + $kuota_pelimpahan_mutasi;
                //         $data = ([
                //             'kuota_pelimpahan' => $kuota_dilimpahkan,
                //             'status_pelimpahan' => 1
                //         ]);
                //         Kuota::where('id', $kuota_mutasi->id)
                //         ->update($data);
                //         $data = ([
                //             'kuota_pelimpahan' => $pendaftar_anakguru,
                //             'status_pelimpahan' => 2
                //         ]);
                //         Kuota::where('id', $kuota_anakguru->id)
                //                 ->update($data);
                //                 $melimpah++;;  
                //     } else if ($status_kuota_domisili == "kurang"){
                //         $kuota_dilimpahkan = $kelebihan_kuota_anakguru + $kuota_pelimpahan_domisili;
                //         $data = ([
                //             'kuota_pelimpahan' => $kuota_dilimpahkan,
                //             'status_pelimpahan' => 1
                //         ]);
                //         Kuota::where('id', $kuota_domisili->id)
                //         ->update($data);
                //         $data = ([
                //             'kuota_pelimpahan' => $pendaftar_anakguru,
                //             'status_pelimpahan' => 2
                //         ]);
                //         Kuota::where('id', $kuota_anakguru->id)
                //                 ->update($data);
                //                 $melimpah++;;  
                //     }
                // }

                // $kuota_mbk = Kuota::where('jalur', 'MURID BERKEBUTUHAN KHUSUS')->where('program_keahlian', $program->program_keahlian)->first();
                // $kuota_pelimpahan_mbk = $kuota_mbk->kuota_pelimpahan;
                // $pendaftar_mbk = Pendaftar::where('jalur', 'MURID BERKEBUTUHAN KHUSUS')->where('pilihan_diterima', $program->program_keahlian)->count();
                // if($kuota_pelimpahan_mbk > $pendaftar_mbk){
                //     $status_kuota_mbk = "lebih";
                //     $kelebihan_kuota_mbk = $kuota_pelimpahan_mbk - $pendaftar_mbk;
                // } else {
                //     $status_kuota_mbk = "kurang";
                // }

                // $kuota_ketm = Kuota::where('jalur', 'KETM')->where('program_keahlian', $program->program_keahlian)->first();
                // $kuota_pelimpahan_ketm = $kuota_ketm->kuota_pelimpahan;
                // $pendaftar_ketm = Pendaftar::where('jalur', 'KETM')->where('pilihan_diterima', $program->program_keahlian)->count();
                // if($kuota_pelimpahan_ketm > $pendaftar_ketm){
                //     $status_kuota_ketm = "lebih";
                //     $kelebihan_kuota_ketm = $kuota_pelimpahan_ketm - $pendaftar_ketm;
                // } else {
                //     $status_kuota_ketm = "kurang";
                // }

                // if ($status_kuota_mbk == "lebih" and $status_kuota_ketm == "kurang"){
                //     $kuota_dilimpahkan = $kelebihan_kuota_mbk + $kuota_pelimpahan_ketm;
                //         $data = ([
                //             'kuota_pelimpahan' => $kuota_dilimpahkan,
                //             'status_pelimpahan' => 1
                //         ]);
                //         Kuota::where('id', $kuota_ketm->id)
                //         ->update($data);
                //         $data = ([
                //             'kuota_pelimpahan' => $pendaftar_mbk,
                //             'status_pelimpahan' => 2
                //         ]);
                //         Kuota::where('id', $kuota_mbk->id)
                //                 ->update($data);
                //                 $melimpah++;;
                // } else if ($status_kuota_ketm == "lebih" and $status_kuota_mbk == "kurang"){
                //     $kuota_dilimpahkan = $kelebihan_kuota_ketm + $kuota_pelimpahan_mbk;
                //         $data = ([
                //             'kuota_pelimpahan' => $kuota_dilimpahkan,
                //             'status_pelimpahan' => 1
                //         ]);
                //         Kuota::where('id', $kuota_mbk->id)
                //         ->update($data);
                //         $data = ([
                //             'kuota_pelimpahan' => $pendaftar_ketm,
                //             'status_pelimpahan' => 2
                //         ]);
                //         Kuota::where('id', $kuota_ketm->id)
                //                 ->update($data);
                //                 $melimpah++;;
                // }                

                $kuota_kna = Kuota::where('jalur', 'KEJUARAAN NON AKADEMIK')->where('program_keahlian', $program->program_keahlian)->first();
                $kuota_pelimpahan_kna = $kuota_kna->kuota_pelimpahan;
                $pendaftar_kna = Pendaftar::where('jalur', 'KEJUARAAN NON AKADEMIK')->where('pilihan_diterima', $program->program_keahlian)->count();
                $cek_pendaftar_tidakditerima_kna = Pendaftar::where('jalur', 'KEJUARAAN NON AKADEMIK')->where('pilihan_diterima', '<>', $program->program_keahlian)
                ->where('pilihan_1',$program->program_keahlian)->orwhere('pilihan_2',$program->program_keahlian)->where('jalur', 'KEJUARAAN NON AKADEMIK')->where('pilihan_diterima', 'Tidak Diterima')->count();
                if($cek_pendaftar_tidakditerima_kna == 0){
                    if($kuota_pelimpahan_kna > $pendaftar_kna){
                        $status_kuota_kna = "lebih";
                        $kelebihan_kuota_kna = $kuota_pelimpahan_kna - $pendaftar_kna;
                    } else {
                        $status_kuota_kna = "pas";
                        $kelebihan_kuota_kna = 0;
                    }
                } else {
                    $status_kuota_kna = "kurang";
                    $kelebihan_kuota_kna = 0;
                }

                $kuota_kepemimpinan = Kuota::where('jalur', 'KEPEMIMPINAN')->where('program_keahlian', $program->program_keahlian)->first();
                $kuota_pelimpahan_kepemimpinan = $kuota_kepemimpinan->kuota_pelimpahan;
                $pendaftar_kepemimpinan = Pendaftar::where('jalur', 'KEPEMIMPINAN')->where('pilihan_diterima', $program->program_keahlian)->count();
                $cek_pendaftar_tidakditerima_kepemimpinan = Pendaftar::where('jalur', 'KEPEMIMPINAN')->where('pilihan_diterima', '<>', $program->program_keahlian)
                ->where('pilihan_1',$program->program_keahlian)->orwhere('pilihan_2',$program->program_keahlian)->where('jalur', 'KEPEMIMPINAN')->where('pilihan_diterima', 'Tidak Diterima')->count();
                if($cek_pendaftar_tidakditerima_kepemimpinan == 0){
                    if($kuota_pelimpahan_kepemimpinan > $pendaftar_kepemimpinan){
                        $status_kuota_kepemimpinan = "lebih";
                        $kelebihan_kuota_kepemimpinan = $kuota_pelimpahan_kepemimpinan - $pendaftar_kepemimpinan;
                    } else {
                        $status_kuota_kepemimpinan = "pas";
                        $kelebihan_kuota_kepemimpinan = 0;
                    }
                } else {
                    $status_kuota_kepemimpinan = "kurang";
                    $kelebihan_kuota_kepemimpinan = 0;
                }

                $kuota_akademik = Kuota::where('jalur', 'KEJUARAAN AKADEMIK')->where('program_keahlian', $program->program_keahlian)->first();
                $kuota_pelimpahan_akademik = $kuota_akademik->kuota_pelimpahan;
                $pendaftar_akademik = Pendaftar::where('jalur', 'KEJUARAAN AKADEMIK')->where('pilihan_diterima', $program->program_keahlian)->count();
                $cek_pendaftar_tidakditerima_akademik = Pendaftar::where('jalur', 'KEJUARAAN AKADEMIK')->where('pilihan_diterima', '<>', $program->program_keahlian)
                ->where('pilihan_1',$program->program_keahlian)->orwhere('pilihan_2',$program->program_keahlian)->where('jalur', 'KEJUARAAN AKADEMIK')->where('pilihan_diterima', 'Tidak Diterima')->count();
                if($cek_pendaftar_tidakditerima_akademik == 0){
                    if($kuota_pelimpahan_akademik > $pendaftar_akademik){
                        $status_kuota_akademik = "lebih";
                        $kelebihan_kuota_akademik = $kuota_pelimpahan_akademik - $pendaftar_akademik;
                    } else {
                        $status_kuota_akademik = "pas";
                        $kelebihan_kuota_akademik = 0;
                    } 
                } else {
                    $status_kuota_akademik = "kurang";
                    $kelebihan_kuota_akademik = 0;
                }

                $kuota_rapor = Kuota::where('jalur', 'PRESTASI NILAI RAPOR')->where('program_keahlian', $program->program_keahlian)->first();
                $kuota_pelimpahan_rapor = $kuota_rapor->kuota_pelimpahan;

                if ($status_kuota_kna == "lebih" and $status_kuota_kepemimpinan == "kurang"){
                    $kuota_dilimpahkan = $kelebihan_kuota_kna + $kuota_pelimpahan_kepemimpinan;
                        $data = ([
                            'kuota_pelimpahan' => $kuota_dilimpahkan,
                            'status_pelimpahan' => 1
                        ]);
                        Kuota::where('id', $kuota_kepemimpinan->id)
                        ->update($data);
                        $data = ([
                            'kuota_pelimpahan' => $pendaftar_kna,
                            'status_pelimpahan' => 2
                        ]);
                        Kuota::where('id', $kuota_kna->id)
                                ->update($data);
                                $melimpah++;;
                } else if ($status_kuota_kepemimpinan == "lebih" and $status_kuota_kna == "kurang"){
                    $kuota_dilimpahkan = $kelebihan_kuota_kepemimpinan + $kuota_pelimpahan_kna;
                        $data = ([
                            'kuota_pelimpahan' => $kuota_dilimpahkan,
                            'status_pelimpahan' => 1
                        ]);
                        Kuota::where('id', $kuota_kna->id)
                        ->update($data);
                        $data = ([
                            'kuota_pelimpahan' => $pendaftar_kepemimpinan,
                            'status_pelimpahan' => 2
                        ]);
                        Kuota::where('id', $kuota_kepemimpinan->id)
                                ->update($data);
                                $melimpah++;;
                } else if ($status_kuota_kepemimpinan == "lebih" or $status_kuota_kna == "lebih"){
                    $kuota_dilimpahkan = $kelebihan_kuota_kna + $kelebihan_kuota_kepemimpinan + $kuota_pelimpahan_rapor;
                    $kuota_pelimpahan_rapor = $kuota_dilimpahkan;
                        $data = ([
                            'kuota_pelimpahan' => $kuota_dilimpahkan,
                            'status_pelimpahan' => 1
                        ]);
                        Kuota::where('id', $kuota_rapor->id)
                        ->update($data);
                        $data = ([
                            'kuota_pelimpahan' => $pendaftar_kepemimpinan,
                            'status_pelimpahan' => 2
                        ]);
                        Kuota::where('id', $kuota_kepemimpinan->id)
                                ->update($data);
                        $data = ([
                            'kuota_pelimpahan' => $pendaftar_kna,
                            'status_pelimpahan' => 2
                        ]);
                        Kuota::where('id', $kuota_kna->id)
                                ->update($data);
                                $melimpah++;;
                }
                if ($status_kuota_akademik == "lebih"){
                        $kuota_dilimpahkan = $kelebihan_kuota_akademik + $kuota_pelimpahan_rapor;
                            $data = ([
                                'kuota_pelimpahan' => $kuota_dilimpahkan,
                                'status_pelimpahan' => 1
                            ]);
                            Kuota::where('id', $kuota_rapor->id)
                            ->update($data);
                            $data = ([
                                'kuota_pelimpahan' => $pendaftar_akademik,
                                'status_pelimpahan' => 2
                            ]);
                            Kuota::where('id', $kuota_akademik->id)
                                    ->update($data);
                                    $melimpah++;;
                } 
                $updatepelimpahan++;
                $pelimpahan = $melimpah;
            }
        }
                    
        return redirect()->back()->with('success', $update . ' Proses seleksi telah dilakukan, '. $updatepelimpahan . ' Proses pelimpahan telah dilakukan');
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
                    $nomor_pendaftaran = $sheet->getCell('N'.$i)->getValue();
                    $nisn = $sheet->getCell('O'.$i)->getValue();
                    $nama = $sheet->getCell('R'.$i)->getValue();
                    $asal_sekolah = $sheet->getCell('S'.$i)->getValue();
                    $pil_1 = $sheet->getCell('T'.$i)->getValue();
                    $pil_2 = $sheet->getCell('U'.$i)->getValue();
                    $pil_3 = "";
                    // $pil_3 = $sheet->getCell('X'.$i)->getValue();
                    $p_1 = explode(" - ", $pil_1);
                    $p_2 = explode(" - ", $pil_2);
                    $p_3 = explode(" - ", $pil_3);
                    $jalur = $p_1[2];
                    $pilihan_1 = $p_1[1];
                    if($pil_2 != ""){
                        if($p_2[0] != "SMKN 1 GARUT"){
                            $pilihan_2 = $p_2[0]." - ".$p_2[1];
                        } else {
                            $pilihan_2 = $p_2[1];
                        }
                    } else {
                        $pilihan_2 = "-";
                    }
                    if($pil_3 != ""){
                        if($p_3[0] != "SMKN 1 GARUT"){
                            $pilihan_3 = $p_3[0]." - ".$p_3[1];
                        } else {
                            $pilihan_3 = $p_3[1];
                        }
                    } else {
                        $pilihan_3 = "-";
                    }
                    // $skor_1 = explode (" ",$sheet->getCell('K'.$i)->getValue());
                    // $skor_2 = explode (" ",$sheet->getCell('K'.$i+1)->getValue());
                    // $skor_3 = explode (" ",$sheet->getCell('K'.$i+2)->getValue());
                    // if(count($skor_1) >= 3){
                    //     if ($p_1[2] =="PERSIAPAN KELAS INDUSTRI"){
                    //         $skor_pilihan_1 = $skor_1[3];
                    //     } else {
                    //         $skor_pilihan_1 = $skor_1[2];
                    //     }
                    // } else {
                    //     $skor_pilihan_1 = 0;
                    // }
                    // if(count($skor_2) >= 3){
                        //     if ($p_1[2] =="PERSIAPAN KELAS INDUSTRI"){
                            //         $skor_pilihan_2 = $skor_2[3];
                            //     } else {
                                //         $skor_pilihan_2 = $skor_2[2];
                                //     }
                                // } else {
                                    //     $skor_pilihan_2 = 0;
                                    // }
                                    // if(count($skor_3) >= 3){
                                        //     if ($p_1[2] =="PERSIAPAN KELAS INDUSTRI"){
                                            //         $skor_pilihan_3 = $skor_3[3];
                                            //     } else {
                                                //         $skor_pilihan_3 = $skor_3[2];
                                                //     }
                                                // } else {
                                                    //     $skor_pilihan_3 = 0;
                    // }
                    $tempat_lahir = $sheet->getCell('X'.$i)->getValue();
                    $tanggal_lahir = $sheet->getCell('Y'.$i)->getValue();
                    $skor_pilihan_1 = $sheet->getCell('V'.$i)->getValue();
                    if($skor_pilihan_1 == ""){
                        $skor_pilihan_1 = 0;
                    }
                    $skor_pilihan_2 = $sheet->getCell('V'.$i)->getValue();
                    if($skor_pilihan_2 == ""){
                        $skor_pilihan_2 = 0;
                    }
                    $skor_pilihan_3 = "";
                    // $skor_pilihan_3 = $sheet->getCell('V'.$i)->getValue();
                    if($skor_pilihan_3 == ""){
                        $skor_pilihan_3 = 0;
                    }
                    $data = ([
                        'nomor_pendaftaran' => $nomor_pendaftaran,
                        'nisn' => $nisn,
                        'nama' => $nama,
                        'tempat_lahir' => $tempat_lahir,
                        'tanggal_lahir' => $tanggal_lahir,
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
            foreach($quotas as $quota){
                $data = ([
                    'kuota_pelimpahan' => $quota->kuota,
                    'status_pelimpahan' => 0
                ]);
                Kuota::where('id', $quota->id)
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
