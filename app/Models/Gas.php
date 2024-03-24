<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gas extends Model
{
    use HasFactory;

    protected $connection = 'oracle-hrms';
    protected $table = 'tb_gas';
    
    protected $primaryKey = 'kd_gas';
	protected $keyType = 'string';
	public $incrementing = false;
}
