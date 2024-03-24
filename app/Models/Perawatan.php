<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Perawatan extends Model
{
    use HasFactory, SoftDeletes;

    public function detail()
    {
    	return $this->hasMany(PerawatanDetail::class, 'perawatan_id', 'id');
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'created_by', 'employee_id');
    }

    public function assigns()
    {
    	return $this->belongsTo(FormPerawatanAssign::class, 'assign_id', 'id');
    }
}
