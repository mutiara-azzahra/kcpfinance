<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Perkiraan extends Model
{
    public $timestamps = false;
    public $table = 'mst_perkiraan';
    protected $primaryKey = 'id';

    public function jurnal_details()
    {
        return $this->hasMany(JurnalDetail::class, 'perkiraan', 'nm_perkiraan');
    }
    
}
