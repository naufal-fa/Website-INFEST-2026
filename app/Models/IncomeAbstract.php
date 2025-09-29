<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeAbstract extends Model
{
    protected $fillable = [
        'team_id',
        'subtheme', 'title',
        'abstract_path', 'commitment_path',
        'submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function registration()
    {
        return $this->belongsTo(IncomeTeam::class, 'id', 'team_id');
    }
}