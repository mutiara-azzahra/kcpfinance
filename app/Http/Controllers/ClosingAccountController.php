<?php

namespace App\Http\Controllers;

use App\SetupPerkiraan;
use Illuminate\Http\Request;

class ClosingAccountController extends Controller
{
    public function index()
    {
        // $perkiraan  = Perkiraan::all();

        return view('closing-account.index');
    }


    public function getClosingAccountBulanan(Request $request){ 

        $periode  = $request->input('periode');

        $getClosingBulanan = SetupPerkiraan::where('periode', $periode)
            ->where('flag_head', 'N')
            ->orderBy('id')->paginate(20);

        return view('closing-account.report',compact('getClosingBulanan', 'periode'))
                ->with('i', (request()->input('page', 1) - 1) * 5);


    }
}
