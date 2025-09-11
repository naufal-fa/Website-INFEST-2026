<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeAbstract extends Model
{
    protected $fillable = [
        'team_id','subtheme','title','abstract_path','commitment_path','submitted_at',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    public function team()
    {
        return $this->belongsTo(IncomeTeam::class, 'team_id');
    }
}
