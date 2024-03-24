<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipePc extends Model
{
    use HasFactory;

    protected $table = 'tb_tipe_pc';
    protected $primaryKey = 'kd_tipe_pc';
    protected $keyType = 'string';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_update_date';
}
