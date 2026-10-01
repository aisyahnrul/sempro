<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Proposal;
use App\Models\User;
use App\Models\Review;

class ProposalVer extends Model
{
    use HasFactory;
    protected $table = 'proposal_ver';
    protected $primaryKey = 'id_ver';
    protected $fillable = [
        'id_prop',
        'versi',
        'file_path',
        'upload_by',
        'uploaded_at',
    ];

    protected $casts = [
        'uploaded_at' => 'datetime',
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'id_prop', 'id_prop');
    }
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'id');
    }
    public function reviews()
    {
        return $this->hasMany(Review::class, 'id_ver', 'id_ver');
    }
    
}
