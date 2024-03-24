<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormPerawatan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'form_perawatans';

    public function detail()
    {
        return $this->hasMany(FormPerawatanDetail::class, 'form_perawatan_id', 'id');
    }

    public function assigns()
    {
    	return $this->hasMany(FormPerawatanAssign::class, 'form_perawatan_id', 'id');
    }
    
    public function latest_assign()
    {
    	return $this->hasOne(FormPerawatanAssign::class, 'form_perawatan_id', 'id')->orderBy('periode_awal', 'desc');
    }
}
