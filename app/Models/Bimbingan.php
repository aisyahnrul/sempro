<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Mahasiswa;
use App\Models\Dosen;
use App\Models\User;
use App\Models\RiwayatBimbingan;

class Bimbingan extends Model
{
    use HasFactory;
    protected $table = 'bimbingan';
    protected $primaryKey = 'id_bimbingan';
    protected $fillable = [
        'id_mhs',
        'id_dosen',
        'assigned_by',
    ];
    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class, 'id_mhs', 'id_mhs');
    }
    public function dosen(){
        return $this->belongsTo(Dosen::class, 'id_dosen', 'id_dosen');
    }   
    public function assignedBy(){
        return $this->belongsTo(Dosen::class, 'assigned_by', 'id_user');
    }
    public function riwayat()
    {
        return $this->hasMany(RiwayatBimbingan::class, 'id_mhs', 'id_mhs');
    }
}
