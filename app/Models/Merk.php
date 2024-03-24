<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merk extends Model
{
    use HasFactory;

    protected $table = 'tb_merk';
    protected $primaryKey = 'kd_merk';
	protected $keyType = 'string';
	public $incrementing = false;

	const CREATED_AT = 'created_date';
	const UPDATED_AT = 'last_update_date';
}
