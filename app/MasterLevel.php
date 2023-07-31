<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterLevel extends Model
{
    public $timestamps = false;
    protected $table = 'mst_level4';
    protected $primaryKey = 'id';

    protected $fillable =[
        'level4',
        'diskon',
        'status',
        'crea_date',
        'modi_date'
    ];

    public function barang()
    {
        return $this->hasMany(MasterBarang::class, 'id', 'id_level');
    }
    
}
