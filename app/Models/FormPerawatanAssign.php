<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FormPerawatanAssign extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'form_perawatan_assigns';

    public function perawatan()
    {
    	return $this->hasOne(Perawatan::class, 'assign_id', 'id');
    }

    public function form_perawatan()
    {
    	return $this->belongsTo(FormPerawatan::class,'form_perawatan_id', 'id');
    }
}
