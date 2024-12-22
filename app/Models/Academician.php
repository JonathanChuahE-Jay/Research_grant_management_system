<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Academician extends Model
{
    protected $fillable = [
        'user_id',
        'staff_number',
        'college',
        'department',
        'position',
    ];
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
    public function grants()
    {
        return $this->belongsToMany(Grant::class, 'grant_academician', 'academician_id', 'grant_id')->withTimestamps();
    }
    public function ledGrants()
    {
        return $this->hasMany(Grant::class, 'academician_id');
    }
}
