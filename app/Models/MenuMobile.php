<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuMobile extends Model
{
    use HasFactory;

    public function in_role()
    {
        return $this->belongsTo(RoleMenuMobile::class, 'id', 'menu_id');
    }

}
