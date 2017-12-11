<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    protected $table = 'keluarga' ;

    public function biodata()
    {
        return $this->belongsTo('App\Models\biodata');
    }

    public function getTanggalLahirAttribute()
    {
        return formatted_date($this->attributes['tanggal_lahir']);
    }
}
