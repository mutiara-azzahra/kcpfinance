<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SetupPerkiraan extends Model
{
    public $timestamps = false;
    public $table = 'setup_perkiraan';
    protected $primaryKey = 'id';


    public function jurnal_details()
    {
        return $this->hasMany(JurnalDetail::class, 'perkiraan');
    }

}
