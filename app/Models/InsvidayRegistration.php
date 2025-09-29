<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InsvidayRegistration extends Model
{
    protected $fillable = [
        'team_name','leader_name','leader_email','leader_whatsapp','member_name','school',
        'requirements_link','status','user_id',
    ];

    public function submission()
    {
        return $this->hasOne(IncomeAbstract::class, 'income_registration_id');
    }
}