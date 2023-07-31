<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SetupPerkiraan;
use App\JurnalDetail;
use Carbon\Carbon;

class NeracaController extends Controller
{
    public function index()
    {   
        return view('neraca.index');
    }

    public function create()
    {
        $neraca = Neraca::all();

        return view('neraca.create', compact('neraca'));
    }

    public function store(Request $request)
    {
        $request -> validate([
            'neraca'     => 'required',
        ]);

        Neraca::create($request->all());
        
        return redirect()->route('neraca.index')->with('success','Data baru berhasil ditambahkan');
    }

    public function show( $id)
    {
        return view('neraca.show', [
            'neraca' => Neraca::findOrFail($id)]);
    }
    
    public function edit( $id)
    {
        $neraca = Neraca::findOrFail($id);

        return view('neraca.edit',compact('neraca'));
    }
  
    public function update(Request $request, Neraca $neraca)
    {
        $request->validate([
            'neraca'     => 'required',
        ]);
         
        $neraca->update($request->all());
         
        return redirect()->route('neraca.index')
                        ->with('success','Data neraca berhasil diubah!');
    }
  
    public function destroy(Neraca $neraca)
    {
        try {
            $neraca->delete();

            return redirect()->route('neraca.index')
                ->with('success','Data neraca berhasil dihapus!');

        } catch (\Throwable $th) {
            return redirect()->route('neraca.index')
                ->with('warning', 'Terjadi kesalahan! Data tidak dapat dihapus');
        }
    }

    public function filter()
    {
        return view('neraca.filter');
    }

    public function getNeraca(Request $request){
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

        //Aktiva KB: Kas dan Bank

        $finalSumSaldoAkhirKB = 0;

        foreach ($saldoAwalNeraca as $s){
            $sumSaldoAkhirKB    = 0;
            $kodePerkiraan      = $s['perkiraan'].'.'.$s['sub_perkiraan'];
            $kodePerkiraanKB    = ['1.1101', '1.1102', '1.1103', '1.1104', '1.1105', '1.1106', '1.1107', '1.1108', '1.1110', '1.1111', '1.1112'];
            
            if (in_array($kodePerkiraan, $kodePerkiraanKB)) {
                
                //$sumSaldoAkhirKB = $s['saldoAwal']+$s['debetSum']-$s['kreditSum'];
                $sumSaldoAkhirKB = $s['saldoAwal']+$s['debetSum']-$s['kreditSum'];
            }

            $finalSumSaldoAkhirKB += $sumSaldoAkhirKB;
        }

        // Deposito: D

        $finalSumSaldoAkhirD = 0;

        foreach ($saldoAwalNeraca as $s){
            $sumSaldoAkhirD    = 0;
            $kodeD             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
            $kodePerkiraanD    = ['1.1109','1.1201', '1.1202', '1.1203'];
            
            if (in_array($kodeD, $kodePerkiraanD)) {
                
                $sumSaldoAkhirD = $s['saldoAwal']+$s['debetSum']-$s['kreditSum'];
            }

            $finalSumSaldoAkhirD += $sumSaldoAkhirD;
        }


        // Piutang Usaha: PU

        $finalSumSaldoAkhirPU = 0;

        foreach ($saldoAwalNeraca as $s){
            $sumSaldoAkhirPU    = 0;
            $kodePU             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
            $kodePerkiraanPU    = ['1.1301', '1.1302'];
            
            if (in_array($kodePU, $kodePerkiraanPU)) {
                
                $sumSaldoAkhirPU = $s['saldoAwal']+$s['debetSum']-$s['kreditSum'];
            }

            $finalSumSaldoAkhirPU += $sumSaldoAkhirPU;
        }

        // Piutang Lainnya: PL

        $finalSumSaldoAkhirPL = 0;

        foreach ($saldoAwalNeraca as $s){
            $sumSaldoAkhirPL    = 0;
            $kodePL             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
            $kodePerkiraanPL    = ['1.1401', '1.1402', '1.1403', '1.1404', '1.1405', '1.1406', '1.1407', '1.1408', '1.1409'];
            
            if (in_array($kodePL, $kodePerkiraanPL)) {
                
                $sumSaldoAkhirPL = $s['saldoAwal']+$s['debetSum']-$s['kreditSum'];
            }

            $finalSumSaldoAkhirPL += $sumSaldoAkhirPL;
        }


        // Persediaan: Persediaan

        $finalSumSaldoAkhirPersediaan = 0;

        foreach ($saldoAwalNeraca as $s){
            $sumSaldoAkhirPersediaan    = 0;
            $kodePersediaan             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
            $kodePerkiraanPersediaan    = ['1.1501', '1.1502','1.1503','1.1504','1.1505','1.1506'];
            
            if (in_array($kodePersediaan, $kodePerkiraanPersediaan)) {
                
                $sumSaldoAkhirPersediaan = $s['saldoAwal']+$s['debetSum']-$s['kreditSum'];
            }

            $finalSumSaldoAkhirPersediaan += $sumSaldoAkhirPersediaan;
        }

        // Pajak Dibayar Dimuka: Pajak

        $finalSumSaldoAkhirPajak = 0;

        foreach ($saldoAwalNeraca as $s){
            $sumSaldoAkhirPajak    = 0;
            $kodePajak             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
            $kodePerkiraanPajak    = ['1.1601', '1.1602','1.1603'];
            
            if (in_array($kodePajak, $kodePerkiraanPajak)) {
                
                $sumSaldoAkhirPajak = $s['saldoAwal']+$s['debetSum']-$s['kreditSum'];
            }

            $finalSumSaldoAkhirPajak += $sumSaldoAkhirPajak;
        }


        // AKTIVA TETAP

        // AT - Peralatan Kantor : PK

        $finalSumSaldoAkhirPK = 0;

        foreach ($saldoAwalNeraca as $s){
            $sumSaldoAkhirPK    = 0;
            $kodePK             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
            $kodePerkiraanPK    = ['1.2110','1.2120'];
            
            if (in_array($kodePK, $kodePerkiraanPK)) {
                
                $sumSaldoAkhirPK = $s['saldoAwal']+$s['debetSum']-$s['kreditSum'];
            }

            $finalSumSaldoAkhirPK += $sumSaldoAkhirPK;
        }

        // AT - Kendaraan : K

        $finalSumSaldoAkhirK = 0;

        foreach ($saldoAwalNeraca as $s){
            $sumSaldoAkhirK    = 0;
            $kodeK             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
            $kodePerkiraanK    = ['1.2210','1.2220'];
            
            if (in_array($kodeK, $kodePerkiraanK)) {
                
                $sumSaldoAkhirK = $s['saldoAwal']+$s['debetSum']-$s['kreditSum'];
            }

            $finalSumSaldoAkhirK += $sumSaldoAkhirK;
        }

        // Kewajiban
        // Kewajiban Lancar

        $finalSumSaldoAkhirKewajiban = 0;

        foreach ($saldoAwalNeraca as $s){
            $sumSaldoAkhirKewajiban    = 0;
            $kodeKewajiban             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
            $kodePerkiraanKewajiban    = ['2.1001','2.1002','2.1003','2.1200', '2.1300', '2.1400', '2.1500','2.1600','2.1702','2.1703','2.1705','2.1706'];
            
            if (in_array($kodeKewajiban, $kodePerkiraanKewajiban)) {
                
                $sumSaldoAkhirKewajiban = $s['saldoAwal']+$s['debetSum']-$s['kreditSum'];
            }

            $finalSumSaldoAkhirKewajiban += $sumSaldoAkhirKewajiban;
        }

        // Hutang Support Program: HSP
        $finalSumSaldoAkhirHSP = 0;

        foreach ($saldoAwalNeraca as $s){
            $sumSaldoAkhirHSP    = 0;
            $kodeHSP             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
            $kodePerkiraanHSP    = ['2.1851'];
            
            if (in_array($kodeHSP, $kodePerkiraanHSP)) {
                
                $sumSaldoAkhirHSP = $s['saldoAwal']+$s['debetSum']-$s['kreditSum'];
            }

            $finalSumSaldoAkhirHSP += $sumSaldoAkhirHSP;
        }

        // Hutang Pajak
        $finalSumSaldoAkhirP = 0;

        foreach ($saldoAwalNeraca as $s){
            $sumSaldoAkhirP    = 0;
            $kodeP             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
            $kodePerkiraanP    = ['2.1900','2.1901','2.1902','2.1903','2.1904','2.1905'];
            
            if (in_array($kodeP, $kodePerkiraanP)) {
                
                $sumSaldoAkhirP = $s['saldoAwal']+$s['debetSum']-$s['kreditSum'];
            }

            $finalSumSaldoAkhirP += $sumSaldoAkhirP;
        }

        //Ekuitas: Setoran Modal
        $finalSetoranModal = 0;
        
        
        foreach ($saldoAwalNeraca as $s){
            $SetoranModal                 = 0;
            $kodeSetoranModal             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
            $kodePerkiraanSetoranModal    = ['3.1000'];
            
            if (in_array($kodeSetoranModal, $kodePerkiraanSetoranModal)) {
                
                $SetoranModal = $s['saldoAwal']+$s['debetSum']-$s['kreditSum'];
            }

            $finalSetoranModal += $SetoranModal;
        }

        //Ekuitas: Laba Rugi Ditahan
        $finalDitahan = 0;
        
        foreach ($saldoAwalNeraca as $s){
            $Ditahan                 = 0;
            $kodeDitahan             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
            $kodePerkiraanDitahan    = ['3.2000'];
            
            if (in_array($kodeDitahan, $kodePerkiraanDitahan)) {
                
                $Ditahan = $s['saldoAwal']+$s['debetSum']-$s['kreditSum'];
            }

            $finalDitahan += $Ditahan;
        }

        //Ekuitas: Laba Rugi Sebelumnya
        $finalSebelumnya = 0;
        
        foreach ($saldoAwalNeraca as $s){
            $Sebelumnya                 = 0;
            $kodeSebelumnya             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
            $kodePerkiraanSebelumnya    = ['3.3000'];
            
            if (in_array($kodeSebelumnya, $kodePerkiraanSebelumnya)) {
                
                $Sebelumnya = $s['saldoAwal']+$s['debetSum']-$s['kreditSum'];
            }

            $finalSebelumnya += $Sebelumnya;
        }


        //Ekuitas: Laba Rugi Berjalan
        $finalBerjalan = 0;
        
        foreach ($saldoAwalNeraca as $s){
            $Berjalan                 = 0;
            $kodeBerjalan             = $s['perkiraan'].'.'.$s['sub_perkiraan'];
            $kodePerkiraanBerjalan    = ['3.4000'];
            
            if (in_array($kodeBerjalan, $kodePerkiraanBerjalan)) {
                
                $Berjalan = $s['saldoAwal']+$s['debetSum']-$s['kreditSum'];
            }

            $finalBerjalan += $Berjalan;
        }

        

        // sum aktiva
        $sumFinalAktiva = $finalSumSaldoAkhirKB + $finalSumSaldoAkhirD + $finalSumSaldoAkhirPU + $finalSumSaldoAkhirPL + $finalSumSaldoAkhirPersediaan + $finalSumSaldoAkhirPajak + $finalSumSaldoAkhirK + $finalSumSaldoAkhirPK;

        // sum kewajiban
        $sumFinalKewajiban = $finalSumSaldoAkhirP + $finalSumSaldoAkhirHSP + $finalSumSaldoAkhirKewajiban;

        //sum ekuitas
        $sumFinalEkuitas = $finalSetoranModal + $finalDitahan + $finalSebelumnya + $finalBerjalan;

        //sum kewajiban+ekuitas
        $sumKewajibanEkuitas = $sumFinalKewajiban + $sumFinalEkuitas;

        //Final Balanced
        $sumBalanced = $sumFinalAktiva - $sumKewajibanEkuitas;



        return view('neraca.report', compact('saldoAwal', 'kodePerkiraan', 'kodePerkiraanKB',
        'sumSaldoAkhirKB','saldoAwalNeraca', 'finalSumSaldoAkhirKB',

        'kodeD', 'kodePerkiraanD',
        'sumSaldoAkhirD', 'finalSumSaldoAkhirD',

        'kodePU', 'kodePerkiraanPU',
        'sumSaldoAkhirPU', 'finalSumSaldoAkhirPU', 

        'kodePL', 'kodePerkiraanPL',
        'sumSaldoAkhirPL', 'finalSumSaldoAkhirPL',

        'kodePersediaan', 'kodePerkiraanPersediaan',
        'sumSaldoAkhirPersediaan', 'finalSumSaldoAkhirPersediaan',

        'kodePajak', 'kodePerkiraanPajak',
        'sumSaldoAkhirPajak', 'finalSumSaldoAkhirPajak',

        'kodePK', 'kodePerkiraanPK',
        'sumSaldoAkhirPK', 'finalSumSaldoAkhirPK',

        'kodeK', 'kodePerkiraanK',
        'sumSaldoAkhirK', 'finalSumSaldoAkhirK',

        'kodeKewajiban', 'kodePerkiraanKewajiban',
        'sumSaldoAkhirKewajiban', 'finalSumSaldoAkhirKewajiban',

        'kodeHSP', 'kodePerkiraanHSP',
        'sumSaldoAkhirHSP', 'finalSumSaldoAkhirHSP',

        'kodeP', 'kodePerkiraanP',
        'sumSaldoAkhirP', 'finalSumSaldoAkhirP',
        
        'perkiraanNeraca','neraca', 'getPilihanBulan','tanggal_awal', 'tanggal_akhir',

        'kodeSetoranModal', 'kodePerkiraanSetoranModal',
        'sumSaldoAkhirSetoranModal', 'finalSumSaldoAkhirSetoranModal',

        'kodeDitahan', 'kodePerkiraanDitahan',
        'sumSaldoAkhirDitahan', 'finalSumSaldoAkhirDitahan',

        'kodeSebelumnya', 'kodePerkiraanSebelumnya',
        'sumSaldoAkhirSebelumnya', 'finalSumSaldoAkhirSebelumnya',

        'kodeBerjalan', 'kodePerkiraanBerjalan',
        'sumSaldoAkhirBerjalan', 'finalSumSaldoAkhirBerjalan',


        'sumFinalAktiva', 'sumFinalKewajiban', 'sumFinalEkuitas', 'sumKewajibanEkuitas', 'sumBalanced'
    ));
    }
}
