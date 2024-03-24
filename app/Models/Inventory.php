<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'office_inventories';
    protected $appends = ["kode_inventaris"];

    public function getKodeInventarisAttribute()
    {
        return substr($this->kode, 0, 2) . '.' . substr($this->kode, 2, 3) . '.' . substr($this->kode, 5, 4);
    }

    public function ruangan()
    {
    	return $this->belongsTo(Ruangan::class, 'ruangan_id', 'id');
    }

    public function jenis()
    {
        return $this->belongsTo(Jenis::class, 'jenis_id', 'id');
    }

    public function pat()
    {
        return $this->belongsTo(Pat::class, 'kd_pat', 'kd_pat');
    }

    public function lokasi()
    {
    	return $this->belongsTo(Pat::class, 'kode_lokasi', 'kd_pat');
    }
}
