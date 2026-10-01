<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Proposal;
use App\Models\Bimbingan;
class Mahasiswa extends Model
{
    use HasFactory;
    protected $table = 'mahasiswa';
    protected $primaryKey = 'id_mhs';
    protected $fillable = [
       'id_user',
       'nama',
       'nim',
    ];

    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
    public function proposal(){
        return $this->hasMany(Proposal::class, 'id_mhs', 'id_mhs');
    }
    public function bimbingan(){
        return $this->hasMany(Bimbingan::class, 'id_mhs', 'id_mhs');
    }
}
