<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provinsi extends Model
{
    // use HasFactory;

    public $timestamps = false;
    public $table = 'mst_provinsi';
    protected $primaryKey = 'kode_prp';

    // protected $table = 'mst_provinsi';
    

    // protected $fillable =[
    //     'provinsi',
    //     'crea_date',
    //     'crea_by',
    //     'modi_date',
    //     'modi_by'
    // ];
   
}
