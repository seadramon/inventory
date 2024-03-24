<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemPc extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tb_item';
    protected $primaryKey = 'kd_item';
    protected $keyType = 'string';

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_update_date';
}
