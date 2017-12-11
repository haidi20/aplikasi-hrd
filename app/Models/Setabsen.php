<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setabsen extends Model
{
    protected $table = 'setabsen';

    public function getTanggalAttribute()
    {
        return formatted_date($this->attributes['tanggal']);
    }
}
