<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fifo extends Model
{
    public $timestamps = false;
    public $table = 'mst_init_fifo';
    

    public function invoice(){
        return $this->hasMany(InvoiceAOPDetails::class,'part_no', 'part_no');
    }

    public function retur(){
        return $this->hasMany(TransaksiReturDetails::class,'part_no', 'part_no');
    }

}
