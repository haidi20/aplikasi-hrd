<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';
    protected $appends = ['foto_url'];

    public function getFotoUrlAttribute()
    {
        if($this->foto){
            return asset('storages/' . $this->foto);
        }else{
            return null;
        }
    }

    public function scopeDepartemenFind($query)
    {
        if (request('departemen')) {
            return $query->where('departemen_id',request('departemen'));
        }
    }

    public function scopeJabatanFind($query)
    {
        if (request('jabatan')) {
            return $query->where('jabatan_id',request('jabatan'));
        }
    }

    public function scopeSiteFind($query)
    {
        if (request('site')) {
            return $query->where('site_id',request('site'));
        }
    }

    public function scopeKodeFind($query)
    {
        if (request('kode')) {
            return $query->where('kode',request('kode'));
        }
    }

    public function scopeNamaFind($query)
    {
        if (request('namaFind')) {
            return $query->where('id',request('namaFind'));
        }
    }

    public function scopeNikFind($query)
    {
        if (request('nikFind')) {
            return $query->where('nik',request('nikFind'));
        }
    }

    public function scopeNama($query)
    {
        if (request('nama')) {
            $nama = request('nama');
            return $query->join('biodata','biodata.id', '=', 'karyawan.biodata_id' )
                         ->where('biodata.nama_lengkap' ,'like','%'.$nama.'%');
        }
    }

    public function getLain_lainAttribute()
    {
        return format_angka($this->attributes['lain_lain']);
    }

    public function getTanggalMasukAttribute()
    {
        return formatted_date($this->attributes['tanggal_masuk']);
    }

    public function getTanggalKeluarAttribute()
    {
        return formatted_date($this->attributes['tanggal_keluar']);
    }

    public function potongan()
    {
        return $this->hasMany('App\Models\Potongan');
    }

    public function hour()
    {
        return $this->hasMany('App\Models\Hour');
    }

    public function hauling()
    {
        return $this->hasMany('App\Models\Hauling');
    }

    public function pengaturan()
    {
        return $this->hasMany('App\Models\Pengaturan');
    }

    public function site()
    {
        return $this->belongsTo('App\Models\site');
    }

    public function trip()
    {
        return $this->belongsTo('App\Models\Trip');
    }

    public function biodata()
    {
        return $this->belongsTo('App\Models\Biodata');
    }

    public function departemen()
    {
        return $this->belongsTo('App\Models\Departemen');
    }

    public function jabatan()
    {
        return $this->belongsTo('App\Models\Jabatan');
    }

    public function absen()
    {
        return $this->hasMany('App\Models\Absen');
    }
}
