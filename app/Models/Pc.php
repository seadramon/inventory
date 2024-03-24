<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pc extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'inv_pc_h';
    protected $primaryKey = 'no_inventaris';
    protected $keyType = 'string';
	public $incrementing = false;

    const CREATED_AT = 'created_date';
    const UPDATED_AT = 'last_update_date';

    protected function status(): Attribute
    {
        $statuses = ['Tidak Aktif', 'Aktif', 'Standby', 'Maintenance'];
        return Attribute::make(
            get: fn ($value) => $statuses[$value]
        );
    }

    protected function nilaiBuku(): Attribute
    {
        $year = Carbon::parse($this->tgl_perolehan)->diff(Carbon::now())->y;
        $depresiasi = optional($this->tipe_pc)->depresiasi;
        $nilai = $depresiasi == null ? $this->hrg_perolehan : (($year >= $depresiasi) ? 1 : (($depresiasi - $year) / $depresiasi * $this->hrg_perolehan));
        return Attribute::make(
            get: fn ($value) => $nilai
        );
    }

    public function pcDetail()
    {
        return $this->hasMany(pcDetail::class, 'no_inventaris', 'no_inventaris');
    }

    public function merk()
    {
    	return $this->belongsTo(Merk::class, 'kd_merk', 'kd_merk');
    }

    public function pat()
    {
        return $this->belongsTo(Pat::class, 'kd_pat', 'kd_pat');
    }

    public function tipe_pc()
    {
        return $this->belongsTo(TipePc::class, 'kd_tipe_pc', 'kd_tipe_pc');
    }

    public function gas()
    {
    	return $this->belongsTo(Gas::class, 'kd_gas', 'kd_gas');
    }

    public function detail()
    {
    	return $this->hasMany(PcDetail::class, 'no_inventaris', 'no_inventaris');
    }
    
    public function pc_softwares()
    {
    	return $this->hasMany(PcSoftware::class, 'no_inventaris', 'no_inventaris');
    }
    
    public function maintenances()
    {
    	return $this->hasMany(Maintenance::class, 'no_inventaris', 'no_inventaris');
    }

    public function personal()
    {
        return $this->belongsTo(Personal::class, 'employee_id','employee_id');
    }
}
