<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PcSoftware extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inv_pc_software';

    public function software()
    {
    	return $this->belongsTo(Software::class, 'software_id', 'id');
    }
}
