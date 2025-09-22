<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsvidayRegistration extends Model
{
    protected $fillable = [
        'user_id','full_name','whatsapp','school',
        'payment_method','payment_proof_path','gdrive_link',
        'status','approved_at','approved_by','visit_date'
    ];
    protected $casts = [
        'visit_date'  => 'date',
        'approved_at' => 'datetime',
    ];

    public function approver() { return $this->belongsTo(\App\Models\User::class, 'approved_by'); }

    public function getWaLinkAttribute(): string { return 'https://wa.me/'.$this->whatsapp; }
}
