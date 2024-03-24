<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Personal extends Model
{
    use HasFactory;

    protected $connection= 'oracle-hrms';
    protected $primaryKey = 'employee_id';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $table = 'personal';

    public function getPenggunaAttribute()
    { 
      return "{$this->employee_id} - {$this->first_name} {$this->last_name}";
    }
}
