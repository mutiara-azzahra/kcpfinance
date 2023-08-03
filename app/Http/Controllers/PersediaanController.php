<?php

namespace App\Http\Controllers;

use App\NilaiPersediaan;
use App\TransaksiReturDetails;
use App\TransaksiInvoiceDetailHet;
use App\TransaksiInvoiceDetails;
use App\ReturAOPDetails;
use App\Fifo;
use App\InvoiceAOPDetails;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PersediaanController extends Controller
{
    public function filter()
    {
        return view('persediaan.filter');
    }

    public function process(Request $request)
    {

        $tanggal_awal   = $request->input('tanggal_awal');
        $tanggal_akhir  = $request->input('tanggal_akhir');
        $kd             = $request->input('area_inv');

        if($kd == 'KS'){
            $kg = 'GD1';
            $kcp = 'KCP01001';
        } elseif ($kd == 'KT'){
            $kg = 'GD2';
            $kcp = 'KCP02001';
        }

        //PERSEDIAAN AWAL INIT
        $getAmountPersediaanAwal = Fifo::where('kd_gudang', $kd)->get();

        $persediaan_awal = 0;

        foreach ($getAmountPersediaanAwal as $i) {
            $amount_persediaan = $i->amt_stock_akhir;
            $persediaan_awal += $amount_persediaan;
        }

        //PEMBELIAN AOP
        $getAmountPembelian = InvoiceAOPDetails::whereHas('header', function ($query) use ($tanggal_awal, $tanggal_akhir, $kg) {
                $query->whereBetween('billingDocument_date', [$tanggal_awal, $tanggal_akhir])
                    ->where('kd_gudang', $kg);
            })->get();
        
        $pembelian = $getAmountPembelian->sum('amount_ex_disc');

        //RETUR AOP
        $getReturAOP = ReturAOPDetails::whereBetween('crea_date', [$tanggal_awal, $tanggal_akhir])->where('kd_gudang_aop', $kcp)->get();

        $retur_aop = 0;

        foreach ($getReturAOP as $item) {
            $retur_aop += $item->qty * $item->price;
        }

        //PENJUALAN KE TOKO
        $getPenjualan = TransaksiInvoiceDetails::whereBetween('crea_date', [$tanggal_awal, $tanggal_akhir])->where('area_inv', $kd)->get();

        $penjualan = $getPenjualan->sum('nominal_total');

        //RETUR DARI TOKO
        $getRetur = TransaksiReturDetails::whereBetween('crea_date', [$tanggal_awal, $tanggal_akhir])->where('area_retur', $kd)->get();

        $retur_toko = $getRetur->sum('nominal_total');

        //MODAL TERJUAL
        $getModalTerjual = TransaksiInvoiceDetailHet::whereBetween('crea_date', [$tanggal_awal, $tanggal_akhir])->where('area_inv', $kd)->get();

        $modal_terjual = $getModalTerjual->sum('nominal_total');

        //PILIH PERSEDIAAN
        $tanggal = new Carbon($tanggal_awal);
        $bulan = $tanggal->format('m');
        $tahun = $tanggal->format('Y');
        
        //PILIH PERSEDIAAN AKHHIR BULAN SEBELUMNYA
        $bulan_prev = $tanggal->subMonth()->format('m');

        $getNilaiPersediaan = NilaiPersediaan::where('bulan', $bulan)->get();


        //INSERT KE TABEL NILAI PERSEDIAAN
        $checkBulan = NilaiPersediaan::where('bulan', $bulan)->first();
        $checkTahun = NilaiPersediaan::where('bulan', $bulan)->first();
        $checkArea = NilaiPersediaan::where('area_inv', $kd)->first();

        $getPersediaanAkhirPrev = NilaiPersediaan::where('bulan', $bulan_prev)->where('area_inv', $kd)->pluck('persediaan_akhir')->first();       
        $persediaan_awal_next = (float) $getPersediaanAkhirPrev;

        
        // if ($checkBulan === null && $checkTahun === null && $checkArea === null) {
        //     //init Januari 2023
        //     $data['bulan']                  = $bulan;
        //     $data['tahun']                  = $tahun;
        //     $data['area_inv']               = $kd;
        //     $data['persediaan_awal']        = $persediaan_awal;
        //     $data['pembelian']              = $pembelian;
        //     $data['retur_aop']              = $retur_aop;
        //     $data['modal_terjual']          = $modal_terjual;
        //     $data['retur_modal_terjual']    = $retur_toko;
        //     $data['persediaan_akhir']       = $persediaan_awal + $pembelian - $retur_aop - $modal_terjual + $retur_toko ;
        //     $data['status']                 = 'Y';
        //     $data['crea_date']              = Carbon::now();

        //    // dd($data);
            
        //   //  NilaiPersediaan::create($data);

           
        // }

        // if ($checkBulan === null && $checkTahun === null && $checkArea === null) {
            //init Januari 2023
            $data['bulan']                  = $bulan;
            $data['tahun']                  = $tahun;
            $data['area_inv']               = $kd;
            $data['persediaan_awal']        = $persediaan_awal_next;
            $data['pembelian']              = $pembelian;
            $data['retur_aop']              = $retur_aop;
            $data['modal_terjual']          = $modal_terjual;
            $data['retur_modal_terjual']    = $retur_toko;
            $data['persediaan_akhir']       = $persediaan_awal_next + $pembelian - $retur_aop - $modal_terjual + $retur_toko ;
            $data['status']                 = 'Y';
            $data['crea_date']              = Carbon::now();
            
            NilaiPersediaan::create($data);
           
       // }

        // return view('persediaan.persediaan', compact('getNilaiPersediaan'));
        return redirect()->route('persediaan.filter')->with('success','Data persediaan baru berhasil ditambahkan!');

    }


    public function getPersediaan(){

        $tablePersediaan = NilaiPersediaan::all();

        return view('persediaan.view', compact('tablePersediaan'));
    }

    public function test(){

        $tablePersediaan = NilaiPersediaan::all();

        return view('persediaan.test');
    }


}
