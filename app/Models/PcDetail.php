<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PcDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inv_pc_d';

    protected $primaryKey = 'kd_item';
    protected $keyType = 'string';
    public $incrementing = false;

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_update_date';

    public function pc()
    {
    	return $this->belongsTo(Pc::class, 'no_inventaris', 'no_inventaris');
    }

    public function item()
    {
    	return $this->belongsTo(ItemPc::class, 'kd_item', 'kd_item');
    }

    public function merk()
    {
    	return $this->belongsTo(Merk::class, 'kd_merk', 'kd_merk');
    }
}
