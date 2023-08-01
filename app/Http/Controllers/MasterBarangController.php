<?php

namespace App\Http\Controllers;

use App\MasterBarang;
use App\MasterModal;
use Illuminate\Http\Request;

class MasterBarangController extends Controller
{
    public function index()
    {
        $barang = MasterBarang::orderBy('id')->get();

        return view('barang.index', compact('barang'));
    }

    public function detail($id){

        $barang = MasterBarang::findOrFail($id);

        $detailBarang = MasterModal::where('id_part_no', $barang->id)->get();

      //  dd($detailBarang);


        return view('barang.detail', compact('barang', 'detailBarang'));
    }

    public function viewUpload(){

        return view('barang.upload');
    }

    
}
