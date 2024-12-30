<?php

namespace App\Http\Controllers;

use App\Models\Milestone;
use App\Models\Grant;
use Illuminate\Http\Request;

class MilestoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin_executive') {
            $milestones = Milestone::with('grant')->paginate(10);
        } else {
            $milestones = Milestone::where(function ($query) use ($user) {
                $query->whereHas('grant', function ($query) use ($user) {
                    $query->where('academician_id', $user->academician->id);
                })
                ->orWhereHas('grant.projectMembers', function ($query) use ($user) {
                    $query->where('academicians.user_id', $user->id);
                });
            })
            ->with('grant')
            ->paginate(10); 
        }
        return view('milestone.index', compact('milestones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = auth()->user();

        if ($user->role === 'admin_executive') {
            $grants = Grant::all();
        } else {
            $grants = Grant::whereHas('projectLeader', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->get();
        }
        return view('milestone.create', compact('grants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();
        $request->validate([
            'name' => 'required|string|max:255',
            'target_completion_date' => 'required|date',
            'deliverable' => 'required',
            'status' => 'required|in:Pending,In Progress,Completed,Delayed',
            'remarks' => 'nullable|string|max:500',
            'grant_id' => 'required|exists:grants,id',
            'updated_date' => 'required|date',
        ]);

        Milestone::create($request->only(['name', 'target_completion_date','deliverable' ,'status', 'remarks', 'updated_date', 'grant_id']));

        return redirect()->route('milestone.index')->with('success', 'Milestone successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Milestone $milestone)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Milestone $milestone)
    {
        $grants = Grant::all();
        return view('milestone.edit', compact('milestone', 'grants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Milestone $milestone)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'target_completion_date' => 'required|date',
            'deliverable' => 'required',
            'status' => 'required|in:Pending,In Progress,Completed,Delayed',
            'remarks' => 'nullable|string|max:500',
            'updated_date' => 'required|date',
        ]);

        $milestone->update($request->only(['name', 'target_completion_date','deliverable', 'status','updated_date', 'remarks']));

        return redirect()->route('milestone.index')->with('success', 'Milestone successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Milestone $milestone)
    {
        $milestone->delete();
        return redirect()->route('milestone.index')->with('success', 'Milestone successfully deleted');
    }
}
