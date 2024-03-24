<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IkDocument extends Model
{
    use HasFactory, SoftDeletes;

    // protected $table   = 'tms_ik_documents';
    protected $visible = ['id', 'file_url'];
    protected $appends = ['file_url'];

    const CATEGORY = [
        'pengoperasian',
        'perawatan',
        'perbaikan'
    ];

    public function getFileUrlAttribute()
    {
        return full_url_from_path($this->path_file);
    }
}
