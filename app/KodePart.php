<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KodePart extends Model
{
    public $timestamps = false;
    protected $table = 'mst_kode_part';
    protected $primaryKey = 'id';

    protected $fillable =[
        'kode',
        'status',
        'crea_date',
        'modi_date'
    ];

   
    public function barang()
    {
        return $this->hasMany(MasterBarang::class, 'id', 'id_part');
    }
}
