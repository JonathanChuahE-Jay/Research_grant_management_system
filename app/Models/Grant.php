<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grant extends Model
{
    protected $fillable = [
        'title',
        'provider',
        'amount',
        'start_date',
        'duration_months',
        'academician_id',
    ];

    protected $casts = [
        'start_date' => 'datetime',
    ];
    
    // Project Leader relationship (one-to-one, from grant to project leader)
    public function projectLeader()
    {
        return $this->belongsTo(Academician::class, 'academician_id');
    }

    // Project Members relationship (many-to-many, from grant to members via pivot table)
    public function projectMembers()
    {
        return $this->belongsToMany(Academician::class, 'grant_academician', 'grant_id', 'academician_id');
    }

    // Milestones relationship (one-to-many, from grant to milestones)
    public function milestones()
    {
        return $this->hasMany(Milestone::class, 'grant_id');
    }
}
