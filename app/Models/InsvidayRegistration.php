<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsvidayRegistration extends Model
{
    protected $fillable = [
        'user_id','full_name','whatsapp','school',
        'batch','visit_date','payment_method',
        'docs','registered_at','docs_submitted_at',
    ];
    protected $casts = [
        'docs' => 'array',
        'visit_date' => 'date',
        'registered_at' => 'datetime',
        'docs_submitted_at' => 'datetime',
    ];

    public function getWaLinkAttribute(): string
    {
        return 'https://wa.me/'.$this->whatsapp;
    }
}
