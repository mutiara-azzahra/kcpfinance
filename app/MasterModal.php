<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MasterModal extends Model
{
    public $timestamps = false;
    protected $table = 'part_aop_modal';
    protected $primaryKey = 'id';

    protected $fillable =[
        'het',
        'id_part_no',
        'status',
        'crea_date',
        'modi_date'
    ];


    public function barang()
    {
        return $this->belongsTo(MasterBarang::class, 'id_part_no', 'id');
    }
}
