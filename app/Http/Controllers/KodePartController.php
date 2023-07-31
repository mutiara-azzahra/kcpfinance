<?php

namespace App\Http\Controllers;

use App\KodePart;

use Carbon\Carbon;
use Illuminate\Http\Request;

class KodePartController extends Controller
{
    public function index()
    {
        $kodePart = KodePart::orderBy('id')->get();

        return view('kode-part.index', compact('kodePart'));
    }

    public function create()
    {
        return view('kode-part.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'kode' => 'required',
        ]);

        $data = $request->all();

        $data['status'] = 'Y';
        $data['crea_date'] = Carbon::now();

        KodePart::create($data);
        
        return redirect()->route('kode-part.index')->with('success','Data baru berhasil ditambahkan!');
    }

    public function edit( $id)
    {
        $kodePart = KodePart::findOrFail($id);

        return view('kode-part.update',compact('kodePart'));
    }

    public function update(Request $request, $id)
    {
        $kodePart = KodePart::findOrFail($id);
        
        $this->validate($request, [
            'kode' => 'required',
            'status' => 'required'
        ]);

        $data = $request->all();

        $data['modi_date'] = Carbon::now();

        $kodePart->update($data);


        return redirect()->route('kode-part.index')->with('success', 'Data berhasil diubah!');
    }
}
