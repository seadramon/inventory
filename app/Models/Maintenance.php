<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    public function signature()
    {
        return $this->morphMany(Signature::class, 'source');
    }

    public function invpch()
    {
        return $this->belongsTo(Pc::class, 'no_inventaris');
    }
}
