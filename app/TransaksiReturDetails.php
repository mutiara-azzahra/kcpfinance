<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransaksiReturDetails extends Model
{
    public $timestamps = false;
    public $table = 'trns_retur_details';

    public function fifo()
    {
        return $this->belongsTo(Fifo::class, 'part_no');
    }
}