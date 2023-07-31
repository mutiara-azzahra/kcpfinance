<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Neraca extends Model
{
    public $timestamps = false;
    protected $table = 'trns_akt_jurnal_header';
    
    
    public function jurnal_detail(){
        return $this->hasMany(JurnalDetail::class,'id_header');
    }
    
}
