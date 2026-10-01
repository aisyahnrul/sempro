<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PengajuanGantiBimbingan extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_ganti_bimbingan';
    protected $primaryKey = 'id_pengajuan';

    protected $fillable = [
        'id_mhs',
        'id_dosen_saat_ini',
        'id_dosen_baru',
        'alasan',
        'status',
        'reviewed_by',
        'reviewed_at',
        'catatan_prodi',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(
            Mahasiswa::class,
            'id_mhs',
            'id_mhs'
        );
    }

    public function dosenSaatIni()
    {
        return $this->belongsTo(
            Dosen::class,
            'id_dosen_saat_ini',
            'id_dosen'
        );
    }

    public function dosenBaru()
    {
        return $this->belongsTo(
            Dosen::class,
            'id_dosen_baru',
            'id_dosen'
        );
    }

    public function reviewer()
    {
        return $this->belongsTo(
            User::class,
            'reviewed_by',
            'id_user'
        );
    }
}