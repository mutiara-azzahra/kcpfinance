<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SetupPerkiraan;
use App\JurnalDetail;
use Carbon\Carbon;

class NeracaSaldoController extends Controller
{
    public function index()
    {
        //$neraca = Neraca::orderBy('nm_perkiraan')->paginate(20);
        
        return view('neraca-saldo.index');
    }

    public function create()
    {
        $neraca = Neraca::all();

        return view('neraca-saldo.create', compact('neraca'));
    }

    public function store(Request $request)
    {
        $request -> validate([
            'neraca'     => 'required',
        ]);

        Neraca::create($request->all());
        
        return redirect()->route('neraca-saldo.index')->with('success','Data baru berhasil ditambahkan');
    }

    public function show( $id)
    {
        return view('neraca-saldo.show', [
            'neraca' => Neraca::findOrFail($id)]);
    }
    
    public function edit( $id)
    {
        $neraca = Neraca::findOrFail($id);

        return view('neraca-saldo.edit',compact('neraca'));
    }
  
    public function update(Request $request, Neraca $neraca)
    {
        $request->validate([
            'neraca'     => 'required',
        ]);
         
        $neraca->update($request->all());
         
        return redirect()->route('neraca-saldo.index')
                        ->with('success','Data neraca berhasil diubah!');
    }
  
    public function destroy(Neraca $neraca)
    {
        try {
            $neraca->delete();

            return redirect()->route('neraca-saldo.index')
                ->with('success','Data neraca berhasil dihapus!');

        } catch (\Throwable $th) {
            return redirect()->route('neraca-saldo.index')
                ->with('warning', 'Terjadi kesalahan! Data tidak dapat dihapus');
        }
    }

    public function filter()
    {
        return view('neraca-saldo.filter');
    }

    public function getNeracaSaldo(Request $request){
        $tanggal_awal   = $request->input('tanggal_awal');
        $tanggal_akhir  = $request->input('tanggal_akhir');

        //Pilih Bulan
        $sliceTanggal = Carbon::createFromFormat('Y-m-d', $tanggal_awal);
        $pilihBulan = $sliceTanggal->subMonth()->format('m');
        $getPilihanBulan = 'saldo_bln'.$pilihBulan;
            
        //Pilih Tahun
        $pilihTahun     = substr($sliceTanggal, 0, 4);
        $numberTahun    = intval($pilihTahun);

        $saldoAwal = SetupPerkiraan::where('periode', $numberTahun)
                ->get();
        
        $saldoAwalBulan = SetupPerkiraan::where('periode', $numberTahun)
                ->pluck($getPilihanBulan)       
                ->all();

        $perkiraanNeraca = JurnalDetail::whereBetween('trx_date', [$tanggal_awal, $tanggal_akhir])
            ->orderBy('perkiraan')
            ->get()
            ->groupBy('perkiraan')
            ->all();

  
        

        $saldoAwalNeraca = $saldoAwal->map(function ($saldo) use ($perkiraanNeraca, $getPilihanBulan) {

            $perkiraan      = $saldo->perkiraan;
            $subPerkiraan   = $saldo->sub_perkiraan;
            $namaPerkiraan  = $saldo->nm_perkiraan;
            $saldoAwal      = $saldo->$getPilihanBulan;


            $key = $subPerkiraan ? $perkiraan . '.' . $subPerkiraan : $perkiraan;

            $debetSum   = 0;
            $kreditSum  = 0;

            if (isset($perkiraanNeraca[$key])) {
                $debetSum   = collect($perkiraanNeraca[$key])->sum('debet');
                $kreditSum  = collect($perkiraanNeraca[$key])->sum('kredit');
            }

            return [
                'perkiraan'         => $perkiraan,
                'sub_perkiraan'     => $subPerkiraan,
                'nama_perkiraan'    => $namaPerkiraan,
                'debetSum'          => $debetSum,
                'kreditSum'         => $kreditSum,
                'saldoAwal'         => $saldoAwal,
            ];
        });
        

        return view('neraca-saldo.report', compact('saldoAwal','saldoAwalNeraca','perkiraanNeraca','neraca', 'getPilihanBulan','concat', 'tanggal_awal', 'tanggal_akhir'));
    }
}
