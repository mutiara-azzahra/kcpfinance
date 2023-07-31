<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceAOPHeader extends Model
{
    public $timestamps = false;
    public $table = 'invoice_aop_headers';
    protected $primaryKey = 'invoice_aop';

    public function details()
    {
        return $this->hasMany(InvoiceAOPDetails::class, 'invoice_aop', 'invoice_aop');
    }
}
