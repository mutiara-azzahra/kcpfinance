<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceAOPDetails extends Model
{
    public $timestamps = false;
    public $table = 'invoice_aop_details';
    protected $primaryKey = 'id';

    public function header()
    {
        return $this->belongsTo(InvoiceAOPHeader::class, 'invoice_aop');
    }

    public function fifo()
    {
        return $this->belongsTo(Fifo::class, 'part_no');
    }
}
