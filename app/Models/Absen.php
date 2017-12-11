<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use DB ;

class Absen extends Model
{
    protected $table = 'absen' ;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    //payrol,
    public function scopeSeluruhStatus($query,$mulai,$akhir)
    {
        return $query->select('karyawan_id',DB::raw("count(status) as total"))
                     ->groupBy('karyawan_id')
                     ->where('status','<>','')
                     ->whereBetween('tanggal', [$mulai, $akhir]);
    }

    public function scopeListAbsen($query,$mulai,$akhir,$idKaryawan)
    {
        return $query->whereBetween('tanggal',[$mulai,$akhir])
                     ->where('karyawan_id',$idKaryawan)
                     ->pluck('status','tanggal');
    }
    // export,slip
    public function scopeJumlahStatus($query,$mulai,$akhir,$id)
    {
        return $query->where('karyawan_id',$id)
                     ->whereBetween('tanggal', [$mulai,$akhir]);
    }

    public function scopeStatus($query,$mulai,$akhir,$id)
    {
        return $query->select('karyawan_id',DB::raw("count(status) as total"))
                     ->groupBy('karyawan_id')
                     ->where('status','<>','')
                     ->where('karyawan_id',$id)
                     ->whereBetween('tanggal', [$mulai, $akhir]);
    }

    public function karyawan()
    {
        return $this->belongsTo('App\Models\Karyawan');
    }
}
