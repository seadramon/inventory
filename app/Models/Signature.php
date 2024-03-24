<?php

namespace App\Models;

use App\Models\Personal;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    use HasFactory;

    public function source()
    {
        return $this->morphTo();
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'sign_by','employee_id');
    }
}
