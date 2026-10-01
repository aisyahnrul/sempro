<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Proposal;
use App\Models\User;

class StatusHistori extends Model
{
    use HasFactory;
    protected $table = 'status_histori';
    protected $primaryKey = 'id_histori';
    public $timestamps = false;
    protected $fillable = [
        'id_prop',
        'status',
        'changed_by',
        'changed_at',
        'note',
    ];

    protected $casts = [
        'changed_at' => 'datetime',
    ];

    public function proposal()
    {
        return $this->belongsTo(Proposal::class, 'id_prop', 'id_prop');
    }
    public function changedBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }
}
