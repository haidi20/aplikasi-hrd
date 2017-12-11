<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB ;

class Hauling extends Model
{
    protected $table = 'hauling' ;

    public function scopeDepartemenFind($query)
    {
        if (request('departemen')) {
            return $query->join('karyawan' , 'hauling.karyawan_id' , '=','karyawan.id')
                         ->join('departemen','karyawan.departemen_id','=','departemen.id')
                         ->where('departemen.id',request('departemen'));
        }
    }

    public function scopeNominalTrip($query)
    {
        return $query->select('karyawan_id', DB::raw('SUM(total) as total'));
    }

    public function scopeTotalTrip($query)
    {
        return $query->select('karyawan_id', DB::raw('SUM(trip) as total'));
    }

    public function scopeKondisiSlip($query,$mulai,$akhir,$idKaryawan)
    {
        return $query->where('karyawan_id',$idKaryawan)
                     ->whereBetween('tanggal',[$mulai,$akhir]);
    }

    public function scopeKondisi($query,$mulai,$akhir,$idKaryawan = null)
    {
        if ($idKaryawan) {
            $query->where('karyawan_id',$idKaryawan);
        }
        return $query->groupBy('karyawan_id')
                     ->whereBetween('tanggal', [$mulai, $akhir])
                     ->pluck('total', 'karyawan_id');
    }

    public function karyawan()
    {
        return $this->belongsTo('App\Models\Karyawan');
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
