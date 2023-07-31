<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provinsi;

class ProvinsiController extends Controller
{
    public function index()
    {
        $provinsi = Provinsi::orderBy('kode_prp')->paginate(5);
        
        return view('provinsi.index',compact('provinsi'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $provinsi = Provinsi::all();

        return view('provinsi.create', compact('provinsi'));
    }

    public function store(Request $request)
    {
        $request -> validate([
            'provinsi'     => 'required',
        ]);

        Provinsi::create($request->all());
        
        return redirect()->route('provinsi.index')->with('success','Data baru berhasil ditambahkan');
    }

    public function show( $id)
    {
        return view('provinsi.show', [
            'provinsi' => Provinsi::findOrFail($id)]);
    }
    
    public function edit( $id)
    {
        $provinsi = Provinsi::findOrFail($id);

        return view('provinsi.edit',compact('provinsi'));
    }
  
    public function update(Request $request, Provinsi $provinsi)
    {
        $request->validate([
            'provinsi'     => 'required',
        ]);
         
        $provinsi->update($request->all());
         
        return redirect()->route('provinsi.index')
                        ->with('success','Data provinsi berhasil diubah!');
    }
  
    public function destroy(Provinsi $provinsi)
    {
        try {
            $provinsi->delete();

            return redirect()->route('provinsi.index')
                ->with('success','Data provinsi berhasil dihapus!');

        } catch (\Throwable $th) {
            return redirect()->route('provinsi.index')
                ->with('warning', 'Terjadi kesalahan! Data tidak dapat dihapus');
        }
    }

    public function filter()
    {
        return view('provinsi.filter');
    }

}
