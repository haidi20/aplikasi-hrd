<?php

namespace App\Models;

use DB ;

use Illuminate\Database\Eloquent\Model;

class Potongan extends Model
{
    protected $table = 'potongan' ;

    public function karyawan()
    {
        return $this->belongsTo('App\Models\Karyawan');
    }

    public function getTanggalAttribute()
    {
        return formatted_date($this->attributes['tanggal']);
    }

    public function scopeKasbon($query)
    {
        return $query->where('kategori','kasbon');
    }

    public function scopeLain($query)
    {
        return $query->where('kategori','Lain-lain');
    }

    public function scopeKondisi($query)
    {
        return $query->select(DB::raw("sum(nominal) as total"));
    }
}
