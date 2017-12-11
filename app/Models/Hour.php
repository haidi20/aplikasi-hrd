<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB ;

class Hour extends Model
{
    protected $table = 'hour' ;

    public function scopeDepartemen($query)
    {
        if (request('departemen')) {
            return $query->join('karyawan','hour.karyawan_id','=','karyawan.id')
                         ->join('departemen','karyawan.departemen_id','=','departemen.id')
                         ->where('departemen.id',request('departemen')) ;
        }
    }

    public function scopeNominalHM($query)
    {
        return $query->select('karyawan_id',DB::raw("sum(total_harga) as total"));
    }
    public function scopeNominalHM2($query)
    {
        return $query->select('karyawan_id',DB::raw("sum(total_des) as total"));
    }

    public function scopeHM($query)
    {
        return $query->select('karyawan_id',DB::raw("sum(total_des) as total"));
    }

    public function scopeKondisiSlip($query,$mulai,$akhir,$idKaryawan)
    {
        return $query->whereBetween('tanggal',[$mulai,$akhir])
                     ->where('karyawan_id',$idKaryawan);
    }

    public function scopeKondisi($query,$mulai,$akhir,$idKaryawan = null)
    {
        if ($idKaryawan) {
            $query->where('karyawan_id',$idKaryawan);
        }
        return $query->groupBy('karyawan_id')
                     ->whereBetween('tanggal',[$mulai,$akhir])
                     ->pluck('total','karyawan_id');
    }

    public function karyawan()
    {
        return $this->belongsTo('App\Models\Karyawan') ;
    }

    public function alat()
    {
        return $this->belongsTo('App\Models\Alat');
    }

    public function getTanggalAttribute()
    {
      return formatted_date($this->attributes['tanggal']);
    }
}
