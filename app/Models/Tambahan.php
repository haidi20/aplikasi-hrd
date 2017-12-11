<?php

namespace App\Models;

use DB ;

use Illuminate\Database\Eloquent\Model;

class Tambahan extends Model
{
    protected $table = 'tambahan' ;

    public function getTanggalAttribute()
    {
        return formatted_date($this->attributes['tanggal']);
    }

    public function scopeKondisi($query)
    {
        return $query->select(DB::raw("sum(nominal) as total"));
    }

    public function karyawan()
    {
        return $this->belongsTo('App\Models\Karyawan');
    }
}
