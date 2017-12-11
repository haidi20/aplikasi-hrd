<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Waktu extends Model
{
    protected $table = 'waktu' ;

    public function hauling()
    {
        return $this->belongsTo('App\Models\Hauling');
    }
}
