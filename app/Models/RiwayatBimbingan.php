<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RiwayatBimbingan extends Model
{
    use HasFactory;

    protected $table = 'riwayat_bimbingan';
    protected $primaryKey = 'id_riwayat';

    public $timestamps = false;

    protected $fillable = [
        'id_mhs',
        'id_dosen_lama',
        'id_dosen_baru',
        'changed_by',
        'alasan',
        'changed_at',
        'sumber',
    ];

    protected $casts = [
        'changed_at' => 'datetime',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mhs', 'id_mhs');
    }

    public function dosenLama()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen_lama', 'id_dosen');
    }

    public function dosenBaru()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen_baru', 'id_dosen');
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by', 'id_user');
    }
}