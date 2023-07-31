<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterBarang extends Model
{
    public $timestamps = false;
    protected $table = 'part_aop_master';

    protected $fillable =[
        'part_no',
        'id_level',
        'id_part',
        'status',
        'crea_date'
    ];

    public function level()
    {
        return $this->belongsTo(MasterLevel::class, 'id_level', 'id');
    }

    public function part()
    {
        return $this->belongsTo(KodePart::class, 'id_part', 'id');
    }
    
     public function modal()
    {
        return $this->hasMany(MasterModal::class, 'id', 'id_part_no');
    }
}
