<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Fifo;

use App\TransaksiReturDetails;
use App\TransaksiInvoiceDetailHet;
use App\TransaksiInvoiceDetails;
use App\ReturAOPDetails;
use App\InvoiceAOPDetails;
use App\NilaiPersediaan;
use App\AreaCustomer;
use Illuminate\Http\Request;

class PersediaanController extends Controller
{

    public function data(){
    
        return view('persediaan.data');
    }

    public function filter()
    {   
        $getDetailsPersediaan = NilaiPersediaan::all();

        return view('persediaan.filter', compact('getDetailsPersediaan'));
    }

    public function index(Request $request)
    {   
        $tanggal_awal   = $request->input('tanggal_awal');
        $tanggal_akhir  = $request->input('tanggal_akhir');
        $kd             = $request->input('area_inv');

        $kg = '';
        $kcp = '';

        if($kd == 'KS'){
            $kg = 'GD1';
            $kcp = 'KCP01001';
        } elseif ($kd == 'KT'){
            $kg = 'GD2';
            $kcp = 'KCP02001';
        }

        $persediaan = Fifo::orderBy('id')->get();

        $persediaanAmount = Fifo::where('kd_gudang', $kd)->get();

        $sumTotalPersediaan = 0;

        foreach ($persediaanAmount as $item) {
            $total_amt_persediaan = $item->amt_stock_akhir;
            $sumTotalPersediaan += $total_amt_persediaan;
        }

        $finalPersediaan = 0;

        $sumPembelian = InvoiceAOPDetails::whereHas('header', function ($query) use ($tanggal_awal, $tanggal_akhir, $kg) {
                $query->whereBetween('billingDocument_date', [$tanggal_awal, $tanggal_akhir])
                    ->where('kd_gudang', $kg);
            })->get();
        
        $finalTotalPembelian = $sumPembelian->sum('amount_ex_disc');


        $sumReturAOP = ReturAOPDetails::whereBetween('crea_date', [$tanggal_awal, $tanggal_akhir])->where('kd_gudang_aop', $kcp)->get();

        $finalTotalReturAOP = 0;

        foreach ($sumReturAOP as $item) {
            $finalTotalReturAOP += $item->qty * $item->price;
        }

        $sumRetur = TransaksiReturDetails::whereBetween('crea_date', [$tanggal_awal, $tanggal_akhir])->where('area_retur', $kd);
        $finalTotalRetur = $sumRetur->sum('nominal_total');

        $sumPenjualan = TransaksiInvoiceDetails::whereBetween('crea_date', [$tanggal_awal, $tanggal_akhir])->where('area_inv', $kd)->get();
        $finalTotalPenjualan = $sumPenjualan->sum('nominal_total');

        $sumPenjualanHet = TransaksiInvoiceDetailHet::whereBetween('crea_date', [$tanggal_awal, $tanggal_akhir])->where('area_inv', $kd)->get();
        $finalTotalPenjualanHet = $sumPenjualanHet->sum('nominal_total');

       dd($finalTotalPenjualanHet);


        $finalPersediaan = $sumTotalPersediaan  + $finalTotalPembelian + $finalTotalRetur - $finalTotalPenjualanHet + $finalTotalReturAOP;

        $finalPersediaanNext = $finalTotalPembelian + $finalTotalRetur - $finalTotalPenjualanHet + $finalTotalReturAOP;

        $t = new Carbon($tanggal_awal);
        $bulanPilih = $t->format('m');
        $tahunPilih = $t->format('Y');

        $persediaanAwalNextIndex = NilaiPersediaan::where('bulan', $bulanPilih)->get();

        foreach ($persediaanAwalNextIndex as $i) {
            $persediaan_awal_index = $i->persediaan_awal;
        }

        //VIEW BARU
        $getDetailsPersediaan = NilaiPersediaan::all();

        $getDetailPersediaanIndex = NilaiPersediaan::where('bulan', $bulanPilih)->get();
        
        $this->getPersediaan($tanggal_awal, $kd, $sumTotalPersediaan, $finalPersediaan, $finalPersediaanNext, $finalTotalPembelian, $finalTotalRetur, $finalTotalPenjualanHet, $finalTotalReturAOP);

        return view('persediaan.index',compact('persediaan', 'finalTotalReturAOP','finalPersediaan', 'sumTotalPersediaan', 'finalTotalPembelian', 'finalTotalRetur', 'finalTotalPenjualan', 'finalTotalPenjualanHet', 'persediaan_awal_index', 'bulanPilih', 'tahunPilih', 'persediaan_awal_index', 'tanggal_awal', 'getDetailsPersediaan'));

    }

     public function getPersediaan($tanggal_awal, $sumTotalPersediaan, $finalPersediaan, $finalPersediaanNext, $finalTotalPembelian, $finalTotalRetur, $finalTotalPenjualanHet, $finalTotalReturAOP){

        dd($finalTotalPenjualanHet);

        $bulan = date('m', strtotime($tanggal_awal));
        $tahun = date('Y', strtotime($tanggal_awal));

        // $carbon_tanggal_awal = new Carbon($tanggal_awal);
        // $last_month = $carbon_tanggal_awal->subMonth()->format('m');
        // $tahun_pilih = $carbon_tanggal_awal->format('Y');

        // $persediaanLastMonth = NilaiPersediaan::where('bulan', $last_month)->get();
        
        // foreach ($persediaanLastMonth as $n) {
        //     $persediaan_akhir = $n->persediaan_akhir;
        // }
        // $formatted_persediaan_akhir = number_format($persediaan_akhir, 2, '.', '');


        $formattedSumTotalPersediaan = number_format($sumTotalPersediaan, 2, '.', '');
        $formattedFinalPersediaan = number_format($finalPersediaan, 2, '.', '');
        $formattedFinalPersediaanNext = number_format($finalPersediaanNext, 2, '.', '');


        $formattedFinalTotalPembelian = number_format($finalTotalPembelian, 2, '.', '');
        $formattedFinalPersediaan = number_format($finalPersediaan, 2, '.', '');

        $fFinalTotalReturAOP = number_format($finalTotalReturAOP, 2, '.', '');
        $fFinalTotalPenjualanHet = number_format($finalTotalPenjualanHet, 2, '.', '');

       

        $checkBulan = NilaiPersediaan::where('bulan', $bulan)->first();
        $checkTahun = NilaiPersediaan::where('bulan', $bulan)->first();
        $checkArea = NilaiPersediaan::where('area_inv', $kd)->first();
        
        if ($checkBulan === null && $checkTahun === null && $checkArea === null) {
            //init Januari 2023
            $data['bulan']              = $bulan;
            $data['tahun']              = $tahun;
            $data['area_inv']           = $kd;
          //  $data['persediaan_awal']    = $formatted_persediaan_akhir;
            $data['persediaan_awal']    = $formattedSumTotalPersediaan;
            $data['pembelian']          = $formattedFinalTotalPembelian;
            $data['retur_aop']          = $fFinalTotalReturAOP;
            $data['modal_terjual']      = $fFinalTotalPenjualanHet;
            $data['retur_modal_terjual'] = $finalTotalRetur;   
           // $data['persediaan_akhir']   = $formattedFinalPersediaanNext;
           $data['persediaan_akhir'] = $formatted_persediaan_akhir + $formattedFinalTotalPembelian - $fFinalTotalReturAOP - $fFinalTotalPenjualanHet + $finalTotalRetur;
            $data['status'] = 'Y';

            //selanjutnya
            $data['crea_date'] = Carbon::now();

            NilaiPersediaan::create($data);

          dd($data);
        }
            
    }

    public function detail($id){

        $tanggal_awal = $tanggal_awal;
        $tanggal_akhir = $tanggal_akhir;

        $persediaan     = Fifo::findOrFail($id);

        $detailPersediaan = InvoiceAOPDetails::where('part_no', $persediaan->part_no)
            ->whereHas('header', function ($query) use ($tanggal_awal, $tanggal_akhir){
                $query->whereBetween('billingDocument_date', [$tanggal_awal, $tanggal_akhir]);
            })
            ->orderBy('invoice_aop', 'ASC')
            ->get();

        $detailRetur = TransaksiReturDetails::where('part_no', $persediaan->part_no)
            ->whereBetween('crea_date', [$tanggal_awal, $tanggal_akhir])
            ->orderBy('id', 'ASC')->get();

        $detailReturAOP = ReturAOPDetails::where('part_no', $persediaan->part_no)
            ->whereBetween('crea_date', [$tanggal_awal, $tanggal_akhir])
            ->orderBy('id', 'ASC')->get();

        $persediaanAwal = Fifo::where('part_no', $persediaan->part_no)
            ->get();

        $persediaanAwalFifo = Fifo::where('part_no', $persediaan->part_no)->pluck('stock_akhir')->first();

        $terjualAwal = 0;

        $persediaanAwalFifoNext = $persediaanAwalFifo;

        //sum persediaan bulanan
        $sumQtyPersediaan = 0;

        foreach($persediaanAwal as $p){
            $qtyPersediaan = $p->stock_akhir;
            $harga_per_pcs = $p->harga_ip;
            $sumQtyPersediaan += $qtyPersediaan;
        }

        $sumQtyPembelian = 0;
        $hargaPembelian = 0;

        foreach($detailPersediaan as $d) {
            $qtyPembelian = $d->qty;
            $hargaPembelian = $d->amount;
            $sumQtyPembelian += $qtyPembelian;
        }


        $sumQtyRetur = 0;

        foreach($detailRetur as $d) {
            $qtyRetur = $d->qty;
            $sumQtyRetur += $qtyRetur;
        }

        $sumQtyPersediaanAkhir = $sumQtyPersediaan + $sumQtyPembelian + $sumQtyRetur;

        //sum amount persediaan bulanan
        $sumAmountPersediaan = 0;
        
        foreach($persediaanAwal as $p){
            $amountPersediaan = $p->amt_stock_akhir;
            $sumAmountPersediaan += $amountPersediaan;
        }

        $sumAmountPembelian = 0;

        foreach($detailPersediaan as $d) {
            $amountPembelian = $d->amount_ex_disc;
            $sumAmountPembelian += $amountPembelian;
        }

        $sumAmountRetur = 0;

        foreach($detailRetur as $d) {
            $amountRetur = $d->nominal_total;
            $sumAmountRetur += $amountRetur;
        }

        $sumAmountPersediaanAwal = $sumAmountPersediaan + $sumAmountPembelian + $sumAmountRetur ;

        //Transaksi Invoice Details

        $terjual = TransaksiInvoiceDetails::where('part_no', $persediaan->part_no)
            ->whereBetween('crea_date', [$tanggal_awal, $tanggal_akhir])
            ->orderBy('id', 'ASC')->get();

        $terjualInit = TransaksiInvoiceDetails::where('part_no', $persediaan->part_no)
            ->whereBetween('crea_date', [$tanggal_awal, $tanggal_akhir])
            ->orderBy('id', 'ASC')
            ->first();

        $sumQtyTerjual = 0;
        $sumFinalFifo = 0;
        $totalQty = 0;

        $sumTotalTerjual = 0;

        foreach ($terjual as $t){

            $totalQty = $t->qty;
            $finalFifo = $totalQty * $harga_per_pcs;

            $sumQtyTerjual += $totalQty;


            $totalTerjual = $t->nominal_total;
            $sumTotalTerjual += $totalTerjual;
        }

        //jumlah pengurang if kondisi 1
        $qtyPembelian = $qtyPersediaan - $sumQtyTerjual;
        
        //harga pengurang if 1
        $hargaFinalPersediaan = $qtyPembelian * $harga_per_pcs;

        //total persediaan akhir
        $totalPersediaanAkhir = $qtyPembelian + $sumQtyPembelian;

        $hargaPersediaanAkhir = $hargaFinalPersediaan + $hargaPembelian + $sumAmountRetur;

        $sum_harga_fifo = $harga_per_pcs * $sumQtyTerjual;

        $cekPartNo = InvoiceAOPDetails::pluck('part_no');
        $getPartNo = $cekPartNo->first();
        
        if (!$detailRetur) {
            $trx_fifo = $persediaanAwal->concat($detailPersediaan);
        } else {
            $trx_fifo = $persediaanAwal->concat($detailPersediaan)->concat($detailRetur);
        }

        $sumCobaTotal1 = 0;
        $sumCobaTotal2 = 0;
        $sumCobaTotal3 = 0;

        foreach ($terjual as $t){

            $cobaTotal1 = $t->qty * $trx_fifo[0]['harga_ip'];
            $cobaTotal2 = $t->qty * $trx_fifo[1]['amount_ex_disc']/$trx_fifo[1]['qty'];
            $cobaTotal3 = $t->qty * $trx_fifo[2]['amount_ex_disc']/$trx_fifo[2]['qty'];


            $sumCobaTotal1 += $cobaTotal1;
            $sumCobaTotal2 += $cobaTotal2;
            $sumCobaTotal3 += $cobaTotal3;
        }

        $finalCT = $sumCobaTotal1 + $sumCobaTotal2 + $sumCobaTotal3;

        // HET DETAILS
        $het = TransaksiInvoiceDetailHet::where('part_no', $persediaan->part_no)
            ->whereBetween('crea_date', [$tanggal_awal, $tanggal_akhir])
            ->orderBy('id', 'ASC')->get();
        
        $sumTotalHet = 0;

        foreach ($het as $h){

            $totalTerjualHet = $h->nominal_total;
            $sumTotalHet += $totalTerjualHet;
        }

        $hargaPersediaanAkhirBaru = $sumAmountPersediaanAwal - $sumTotalHet;

        $qtyPersediaanAkhirBaru = $sumQtyPersediaanAkhir - $sumQtyTerjual;
   
        return view('persediaan.detail', compact('sumQty','persediaan','detailPersediaan', 'detailRetur', 'persediaanAwal', 'sumQtyPersediaan','sumQtyPersediaanAkhir', 'sumAmountPersediaanAwal', 'terjual','sumQtyTerjual', 'sumTotalTerjual', 'qtyPersediaan', 'qtyPembelian', 'hargaFinalPersediaan', 'hargaPersediaanAkhir', 'totalPersediaanAkhir', 'harga_fifo', 'sum_harga_fifo', 'totalQty', 'harga_per_pcs', 'sumFinalFifo', 'trx_fifo', 'qtyTerjualFifo', 'persediaanAwalFifo', 'terjualInit', 'persediaanAwalFifoNext', 'terjualAwal', 'het', 'sumTotalHet', 'hargaPersediaanAkhirBaru', 'qtyPersediaanAkhirBaru'));
        
    }

}
