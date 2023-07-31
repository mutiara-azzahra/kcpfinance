<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Perkiraan;
use App\Jurnal;
use App\JurnalDetail;
use App\SetupPerkiraan;
use Illuminate\Support\Facades\Blade;


class BukuBesarController extends Controller
{
    public function index()
    {
        $perkiraan  = Perkiraan::all();

        return view('buku-besar.index', compact('perkiraan'));
    }

    public function getBukuBesarPerkiraan(Request $request)
    {
            $tanggal_awal   = $request->input('tanggal_awal');
            $tanggal_akhir  = $request->input('tanggal_akhir');
            $perkiraan      = $request->input('perkiraan');

            //Pilih Bulan
            $sliceTanggal = Carbon::createFromFormat('Y-m-d', $tanggal_awal);
            $pilihBulan = $sliceTanggal->subMonth()->format('m');
            $getPilihanBulan = 'saldo_bln'.$pilihBulan;
            
            //Pilih Tahun
            $pilihTahun = substr($sliceTanggal, 0, 4);
            $numberTahun    = intval($pilihTahun);

            $slicePerkiraan     = DB::select(DB::raw("SELECT substring($perkiraan, 1,1) AS perkiraan FROM kcpinformation.setup_perkiraan"));
            $numberPerkiraan    = intval($slicePerkiraan);

            $sliceSubPerkiraan  = Str::after($perkiraan, '.');
            $numberSubPerkiraan = intval($sliceSubPerkiraan);

            $saldoAwalPerkiraan = SetupPerkiraan::where('periode', $numberTahun)
                ->where('perkiraan', $numberPerkiraan)
                ->where('sub_perkiraan', $numberSubPerkiraan)
                ->pluck($getPilihanBulan)
                ->all();

            $firstElement = $saldoAwalPerkiraan[0];
            $escapedValue = floatval($firstElement);

            $bukuBesar = JurnalDetail::where('perkiraan', $perkiraan)
                ->whereBetween('trx_date', [$tanggal_awal, $tanggal_akhir])
                ->orderBy('id_header')
                ->get()->all();

            $dataArray0 = $bukuBesar[0]->debet;

            $totalDebet = 0;
            $totalKredit = 0;

            foreach ($bukuBesar as $jd){
                $totalDebet += $jd->debet;
                $totalKredit += $jd->kredit;
            }
            $saldoAwal = $escapedValue;

            $initSaldo = $saldoAwal + $dataArray0;

         
            return view('buku-besar.report',compact('bukuBesar','saldoAwal', 'initSaldo','escapedValue','perkiraan', 'saldoAwalPerkiraan', 'tanggal_awal', 'tanggal_akhir', 'totalDebet', 'totalKredit'))
                ->with('i', (request()->input('page', 1) - 1) * 5);

    }

    public function boot()
    {
        Blade::directive('rupiah', function ( $expression ) { 
            return "Rp. ". number_format($expression,0,',','.');
        });
    }


}
