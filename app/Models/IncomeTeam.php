<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomeTeam extends Model
{
    protected $fillable = [
        'user_id','team_name','leader_name','member_name','school',
        'leader_whatsapp','leader_email','requirements_link','registered_at',
    ];

    protected $casts = [
        'registered_at' => 'datetime',
    ];

    public function submission()
    {
        return $this->hasOne(IncomeAbstract::class, 'team_id');
    }
}
