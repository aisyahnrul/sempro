<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Proposal;

class Jadwal extends Model
{
    use HasFactory;
    protected $table = 'jadwal';
    protected $primaryKey = 'id_jadwal';
    // public const UPDATE_AT = null;

    public $timestamps = false;
    protected $fillable = [
        'id_prop',
        'tanggal',
        'waktu',
        'tempat',
        'ruang',
        'created_by',
        'created_at'
    ];

    protected $casts = [
        'tanggal' => 'date',
        'waktu' => 'string',
        'created_at' => 'datetime',
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'id_prop', 'id_prop');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }
}
