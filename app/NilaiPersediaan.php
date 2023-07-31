<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NilaiPersediaan extends Model
{
    public $timestamps = false;
    public $table = 'nilai_persediaan';
    protected $primaryKey = 'id';

    protected $fillable =[
        'bulan',
        'tahun',
        'area_inv',
        'persediaan_awal',
        'pembelian',
        'retur_aop',
        'modal_terjual',
        'retur_modal_terjual',   
        'persediaan_akhir',
        'status',
        'crea_date',
        'modi_date'
    ];
}
