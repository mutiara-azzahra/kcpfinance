<?php

namespace App\Http\Controllers;

use App\MasterLevel;
use App\MasterLevelDetail;

use Carbon\Carbon;
use Illuminate\Http\Request;

class MasterLevelController extends Controller
{
    public function index()
    {
        $level = MasterLevel::orderBy('id')->get();

        return view('level.index', compact('level'));
    }

    public function create()
    {
        return view('level.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'level4' => 'required',
            'diskon' => 'required',
            'status' => 'required'
        ]);

        $data = $request->all();

        $data['crea_date'] = Carbon::now();

        MasterLevel::create($data);
        
        return redirect()->route('level.index')->with('success','Data baru berhasil ditambahkan!');
    }

    public function edit( $id)
    {
        $level = MasterLevel::findOrFail($id);

        return view('level.update',compact('level'));
    }

    public function update(Request $request, $id)
    {
        $level = MasterLevel::findOrFail($id);
        
        $this->validate($request, [
            'level4' => 'required',
            'diskon' => 'required',
            'status' => 'required'
        ]);

        $data = $request->all();

        $data['modi_date'] = Carbon::now();

        $level->update($data);


        return redirect()->route('level.index')->with('success', 'Data berhasil diubah!');
    }


    public function delete(Request $request, $id){
        $level = MasterLevel::findOrFail($id);

        $data['status'] = 'N';

        $level->update($data);

    }

    public function destroy(MasterLevel $level)
    {
        try {
            $level->delete();

            return redirect()->route('level.index')
                ->with('success','Data level 4 berhasil dihapus!');

        } catch (\Throwable $th) {
            return redirect()->route('level.index')
                ->with('warning', 'Terjadi kesalahan! Data '.$level->level4.' tidak dapat dihapus');
        }
    }
}
