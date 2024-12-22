<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grant;
use App\Models\Academician;
use App\Models\Milestone;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();
        
        $totalGrants = 0;
        $totalAcademicians = 0;
        $totalMilestones = 0;
        $assignedGrants = 0;
        $milestonesInvolved = 0;
        
        if ($user->role === 'admin_executive') {
            $totalGrants = Grant::count();
            $totalAcademicians = Academician::count();
            $totalMilestones = Milestone::count();
        } else  {
            $assignedGrants = Grant::where(function ($query) use ($user) {
                $query->where('academician_id', $user->academician->id)
                      ->orWhereHas('projectMembers', function ($query) use ($user) {
                          $query->where('academicians.user_id', $user->id); 
                      });
            })->count();

            $milestonesInvolved = Milestone::whereHas('grant.projectMembers', function ($query) use ($user) {
                $query->where('academicians.user_id', $user->id);
            })
            ->orWhereHas('grant', function ($query) use ($user) {
                $query->where('academician_id', $user->academician->id);
            })
            ->count();
        }
        
        return view('home', compact(
            'totalGrants',
            'totalAcademicians',
            'totalMilestones',
            'assignedGrants',
            'milestonesInvolved'
        ));
    }
}
