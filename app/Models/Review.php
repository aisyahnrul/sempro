<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ProposalVer;
use App\Models\Dosen;

class Review extends Model
{
    use HasFactory;
    protected $table = 'review';
    protected $primaryKey = 'id_review';
    protected $fillable = [
        'id_ver',
        'id_dosen',
        'komentar',
    ];

    public function proposalVer()
    {
        return $this->belongsTo(ProposalVer::class, 'id_ver', 'id_ver');
    }
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'id_dosen', 'id_dosen');
    }
}
