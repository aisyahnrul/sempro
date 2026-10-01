<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Mahasiswa;
use App\Models\ProposalVer;
use App\Models\StatusHistori;
use App\Models\Jadwal;

class Proposal extends Model
{
    use HasFactory;
    protected $table = 'proposal';
    protected $primaryKey = 'id_prop';
    protected $fillable = [
        'id_mhs',
        'judul',
        'status',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mhs', 'id_mhs');
    }   
    public function proposalVer()
    {
        return $this->hasMany(ProposalVer::class, 'id_prop', 'id_prop');
    }
    public function statusHistori()
    {
        return $this->hasMany(StatusHistori::class, 'id_prop', 'id_prop');
    }       
    public function jadwal()
    {
        return $this->hasOne(Jadwal::class, 'id_prop', 'id_prop');
    }   
}
