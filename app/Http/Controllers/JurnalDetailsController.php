<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JurnalDetailsController extends Controller
{
    public function index()
    {
        $jurnalDetail = JurnalDetail::orderBy('trx_date', 'DESC')->paginate(20);

        // dd($jurnalDetail);

        return view('jurnal.index',compact('jurnal'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
}
