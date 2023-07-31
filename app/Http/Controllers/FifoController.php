<?php

namespace App\Http\Controllers;
use App\Fifo;

use Illuminate\Http\Request;

class FifoController extends Controller
{
    public function index()
    {
        $fifo = Fifo::orderBy('id')->paginate(5);
        
        return view('fifo.index',compact('fifo'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $fifo = Fifo::all();

        return view('fifo.create', compact('fifo'));
    }

    public function store(Request $request)
    {
        $request -> validate([
        'status'        => 'required',
        'keterangan'    => 'required',
        'kd_gudang'     => 'required',
        'part_no'       => 'required',
        'qty'           => 'required',
        'debet'         => 'required',
        'kredit'        => 'required',
        'beli_qty'      => 'required',
        'beli_harga'    => 'required',
        'beli_total'    => 'required',
        'hpp_qty'       => 'required',
        'hpp_harga'     => 'required',
        'hpp_total'     => 'required',
        'persediaan_qty'    => 'required',
        'persediaan_harga'  => 'required',
        'persediaan_total'  => 'required'
        ]);

        Fifo::create($request->all());
        
        return redirect()->route('fifo.index')->with('success','Data baru berhasil ditambahkan');
    }

    public function show( $id)
    {
        return view('fifo.show', [
            'fifo' => Fifo::findOrFail($id)]);
    }
    
    public function edit( $id)
    {
        $fifo = Fifo::findOrFail($id);

        return view('fifo.edit',compact('fifo'));
    }
  
    public function update(Request $request, Fifo $fifo)
    {
        $request->validate([
            'fifo'     => 'required',
        ]);
         
        $fifo->update($request->all());
         
        return redirect()->route('fifo.index')
                        ->with('success','Data fifo berhasil diubah!');
    }
  
    public function destroy(Fifo $fifo)
    {
        try {
            $fifo->delete();

            return redirect()->route('fifo.index')
                ->with('success','Data fifo berhasil dihapus!');

        } catch (\Throwable $th) {
            return redirect()->route('fifo.index')
                ->with('warning', 'Terjadi kesalahan! Data tidak dapat dihapus');
        }
    }

    public function filter()
    {
        return view('fifo.filter');
    }

}
