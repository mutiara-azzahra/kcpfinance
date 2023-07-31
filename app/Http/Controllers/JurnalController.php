<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jurnal;
use App\JurnalDetail;
use Carbon\Carbon;

class JurnalController extends Controller
{
    public function index()
    {
        $jurnal = Jurnal::orderBy('trx_date', 'DESC')->paginate(20);

        
        return view('jurnal.index',compact('jurnal'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $jurnal = Jurnal::all();

        return view('jurnal.create', compact('jurnal'));
    }

    public function store(Request $request)
    {
        $request -> validate([
            'jurnal'     => 'required',
        ]);

        Jurnal::create($request->all());
        
        return redirect()->route('jurnal.index')->with('success','Data baru berhasil ditambahkan');
    }

    public function show( $id)
    {
        return view('jurnal.show', [
            'jurnal' => Jurnal::findOrFail($id)]);
    }
    
    public function edit( $id)
    {
        $jurnal = Jurnal::findOrFail($id);

        return view('jurnal.edit',compact('jurnal'));
    }
  
    public function update(Request $request, Jurnal $jurnal)
    {
        $request->validate([
            'jurnal'     => 'required',
        ]);
         
        $jurnal->update($request->all());
         
        return redirect()->route('jurnal.index')
                        ->with('success','Data jurnal berhasil diubah!');
    }
  
    public function destroy(Jurnal $jurnal)
    {
        try {
            $jurnal->delete();

            return redirect()->route('jurnal.index')
                ->with('success','Data jurnal berhasil dihapus!');

        } catch (\Throwable $th) {
            return redirect()->route('jurnal.index')
                ->with('warning', 'Terjadi kesalahan! Data tidak dapat dihapus');
        }
    }

    // public function getJurnalHeader($tanggal_awal, $tanggal_akhir){

    //     $jurnalHeader = Jurnal::whereBetween('trx_date', 
    //         [
    //             Carbon::createFromFormat('Y-m-d', $tanggal_awal),
    //             Carbon::createFromFormat('Y-m-d', $tanggal_akhir),

    //         ])->where('flag_batal', 'N')->orderBy('trx_date')->get();


    //         return view('jurnal.report',compact('tanggal_awal', 'tanggal_akhir'))
    //                 ->with('i', (request()->input('page', 1) - 1) * 5);

    // }

    public function getJurnalHeader(Request $request)
    {

        $jurnalHeader   = Jurnal::whereBetween('trx_date', 
            [
                $tanggal_awal = $request->input('tanggal_awal'),
                $tanggal_akhir = $request->input('tanggal_akhir'),

            ])->where('flag_batal', 'N')->orderBy('trx_date')->paginate(20);

            

        return view('jurnal.report',compact('jurnalHeader', 'tanggal_awal', 'tanggal_akhir'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

 

}
