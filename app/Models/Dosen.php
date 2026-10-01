<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Bimbingan;
use App\Models\Review;

class Dosen extends Model
{
    use HasFactory;
    protected $table = 'dosen';
    protected $primaryKey = 'id_dosen';
    protected $fillable = [
        'id_user',
        'nip',
        'nama',
        'max_bimbingan',
    ];
    public function user(){
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
    public function bimbingan(){
        return $this->hasMany(Bimbingan::class, 'id_dosen', 'id_dosen');
    }
    public function review(){
        return $this->hasMany(Review::class, 'id_dosen', 'id_dosen');
    }
}
