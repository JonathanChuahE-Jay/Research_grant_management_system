<?php

namespace App\Http\Controllers;

use App\Models\Academician;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AcademicianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $academicians = Academician::with('user')->paginate(10);
        return view('academician.index', compact('academicians'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create',Academician::class);
        return view('academician.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create',Academician::class);
        $validated = $request->validate([
            'staff_number' => 'required',
            'college' => 'required',
            'department' => 'required',
            'position' => 'required',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
        ]);

        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }elseif (!$profilePicturePath) {
            $profilePicturePath = 'images/default_profile_picture.png';
        }

        $user = User::create([
            'name' => $validated['name'],
            'profile_picture' => $profilePicturePath,
            'email' => $validated['email'],
            'password' => Hash::make('uni10pass!'),
            'role' => 'project_member',
        ]);

        Academician::create([
            'staff_number' => $validated['staff_number'],
            'college' => $validated['college'],
            'department' => $validated['department'],
            'position' => $validated['position'],
            'user_id' => $user->id,
        ]);

        return redirect()->route('academician.index')->with('success', 'Academician created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Academician $academician)
    {
        $leaderGrants = $academician->ledGrants()->get(); 
        $memberGrants = $academician->grants()->get();

        $grants = $leaderGrants->merge($memberGrants)->map(function ($grant) use ($academician) {
            $grant->role = $grant->academician_id == $academician->id ? 'Project Leader' : 'Member';
            return $grant;
        });

        return view('academician.show', compact('academician', 'grants'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Academician $academician)
    {
        $this->authorize('update',$academician);
        return view('academician.edit', compact('academician'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Academician $academician)
    {
        $this->authorize('update', $academician);

        $validated = $request->validate([
            'staff_number' => 'required',
            'college' => 'required',
            'department' => 'required',
            'position' => 'required',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $academician->user->id,
        ]);

        $profilePicturePath = $academician->user->profile_picture; 
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }elseif (!$profilePicturePath) {
            $profilePicturePath = 'images/default_profile_picture.png';
        }

        $user = $academician->user;
        $user->update([
            'name' => $validated['name'],
            'profile_picture' => $profilePicturePath,
            'email' => $validated['email']
        ]);

        $academician->update([
            'staff_number' => $validated['staff_number'],
            'college' => $validated['college'],
            'department' => $validated['department'],
            'position' => $validated['position'],
        ]);

        return redirect()->route('academician.index')->with('success', 'Academician updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Academician $academician)
    {
        $this->authorize('delete',$academician);
        $user = $academician->user;
        $academician->delete();
        $user->delete();

        return redirect()->route('academician.index')->with('success', 'Academician deleted successfully.');
    }
}
