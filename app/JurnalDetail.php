<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JurnalDetail extends Model
{
    public $timestamps = false;
    protected $table = 'trns_akt_jurnal_details';
    protected $primaryKey = 'id';

    public function perkiraan()
    {
        return $this->belongsTo(Perkiraan::class, 'perkiraan');
    }

    public function jurnal(){
        return $this->belongsTo(Jurnal::class,'id_header');
    }

    public function neraca(){
        return $this->belongsTo(Neraca::class,'id_header');
    }

    public function setup_perkiraan()
    {
        return $this->belongsTo(SetupPerkiraan::class, 'perkiraan');
    }

}
