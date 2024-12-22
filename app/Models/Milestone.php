<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Milestone extends Model
{
    protected $fillable = ['target_completion_date','deliverable','name','status','remarks','updated_date','grant_id'];
    
    protected $casts = [
        'target_completion_date' => 'datetime',
        'updated_date' => 'datetime',
    ];
    
    public function grant()
    {
        return $this->belongsTo(Grant::class, 'grant_id');
    }
}
