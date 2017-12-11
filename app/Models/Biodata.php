<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Biodata extends Model
{
    protected $table = 'biodata' ;

    public function scopeFindNama($query)
    {
        if (request('nama')) {
            $query->where('id',request('nama'));
        }
    }

    public function Karyawan()
    {
        return $this->hasMany('App\Models\Karyawan');
    }

    public function keluarga()
    {
        return $this->hasMany('App\Models\Keluarga');
    }

    public function getTanggalLahirAttribute()
    {
        return formatted_date($this->attributes['tanggal_lahir']);
    }

    public function getAkhirKtpAttribute()
    {
        return formatted_date($this->attributes['akhir_ktp']);
    }

    public function  getTahunMasukAttribute()
    {
        return formatted_year($this->attributes['tahun_masuk']);
    }

    public function  getTahunKelulusanAttribute()
    {
        return formatted_year($this->attributes['tahun_kelulusan']);
    }

    public function getTanggalKeluarAttribute()
    {
        return formatted_date($this->attributes['tanggal_keluar']);
    }
}
