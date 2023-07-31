<?php

namespace App\Http\Controllers;
use App\Perkiraan;

use Illuminate\Http\Request;

class PerkiraanController extends Controller
{
    public function index()
    {
        $perkiraan = Perkiraan::orderBy('nm_perkiraan')->paginate(20);
        
        return view('perkiraan.index', compact('perkiraan'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function create()
    {
        $perkiraan = Perkiraan::all();

        return view('perkiraan.create', compact('perkiraan'));
    }

    public function store(Request $request)
    {
        $request -> validate([
            'perkiraan'     => 'required',
        ]);

        Perkiraan::create($request->all());
        
        return redirect()->route('perkiraan.index')->with('success','Data baru berhasil ditambahkan');
    }

    public function show( $id)
    {
        return view('perkiraan.show', [
            'perkiraan' => Perkiraan::findOrFail($id)]);
    }
    
    public function edit( $id)
    {
        $perkiraan = Perkiraan::findOrFail($id);

        return view('perkiraan.edit',compact('perkiraan'));
    }

    public function update(Request $request, Perkiraan $perkiraan)
    {
        $request->validate([
            'perkiraan'     => 'required',
        ]);
         
        $perkiraan->update($request->all());
         
        return redirect()->route('perkiraan.index')
                        ->with('success','Data perkiraan berhasil diubah!');
    }
  
    public function destroy(Perkiraan $perkiraan)
    {
        try {
            $perkiraan->delete();

            return redirect()->route('perkiraan.index')
                ->with('success','Data perkiraan berhasil dihapus!');

        } catch (\Throwable $th) {
            return redirect()->route('perkiraan.index')
                ->with('warning', 'Terjadi kesalahan! Data tidak dapat dihapus');
        }
    }

    public function filter()
    {
        return view('perkiraan.filter');
    }

    
}
