<?php

namespace App\Http\Controllers;

use App\Models\Grant;
use App\Models\User;
use App\Models\Academician;
use App\Models\Milestone;
use Illuminate\Http\Request;

class GrantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'admin_executive') {
            $grants = Grant::with('projectLeader.user')->paginate(10);
        } else {
            $grants = Grant::where(function ($query) use ($user) {
                $query->where('academician_id', $user->academician->id)
                      ->orWhereHas('projectMembers', function ($query) use ($user) {
                          $query->where('academicians.id', $user->academician->id);
                      });
            })
            ->with(['projectLeader.user', 'projectMembers']) 
            ->paginate(10);
        }

        return view('grant.index', compact('grants'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Grant::class);
        $academicians = Academician::with('user')
            ->whereHas('user', function ($query) {
                $query->where('role', 'project_member');
            })
            ->get();

        return view('grant.create', compact('academicians'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create',Grant::class);
        $request->validate([
            'title' => 'required|string|max:255',
            'provider' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'duration_months' => 'required|integer|min:1',
            'academician_id' => 'required|exists:academicians,id',
            'project_member_Ids' => 'array|required|min:1',
            'project_member_Ids.*' => 'exists:academicians,id',
        ]);

        $grant = Grant::create($request->only([
            'title',
            'provider',
            'amount',
            'start_date',
            'duration_months',
            'academician_id',
        ]));

        if ($request->has('project_member_Ids')) {
            $grant->projectMembers()->attach($request->input('project_member_Ids'));
        }

        return redirect()->route('grant.index')->with('success', 'Grant successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Grant $grant)
    {
        $grant = $grant->load('projectLeader');
        $members = $grant->projectMembers()->paginate(5);
        $milestones = $grant->milestones()->paginate(5);
        return view('grant.show',compact('grant', 'members','milestones'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grant $grant)
    {
        $this->authorize('update',$grant);
        $academicians = Academician::with('user')
            ->whereHas('user', function ($query) {
                $query->where('role', 'project_member');
            })
            ->get();
        $grant = $grant->load('projectLeader');
        return view('grant.edit',compact('grant','academicians'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grant $grant)
    {
        $this->authorize('update',$grant);
        $request->validate([
            'title' => 'required|string|max:255',
            'provider' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            'duration_months' => 'required|integer|min:1',
            'academician_id' => 'required|exists:academicians,id',
            'project_member_Ids' => 'required|array',
            'project_member_Ids.*' => 'exists:academicians,id',
        ]);

        $grant->update([
            'title' => $request->input('title'),
            'provider' => $request->input('provider'),
            'amount' => $request->input('amount'),
            'start_date' => $request->input('start_date'),
            'duration_months' => $request->input('duration_months'),
            'academician_id' => $request->input('academician_id'),
        ]);

        if ($request->has('project_member_Ids')) {
            $grant->projectMembers()->sync($request->input('project_member_Ids'));
        } else {
            $grant->projectMembers()->detach();
        }

        return redirect()->route('grant.index')->with('success', 'Grant successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grant $grant)
    {
        $this->authorize('delete',$grant);
        $grant->delete();
        return redirect()->route('grant.index')->with('Success','Grant successfully deleted');
    }
}
