<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        return view('profile.index', compact('user'));
    }

    public function edit(Request $request)
    {
        $user = $request->user(); 
        $user->load('academician');
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validatedData = $request->validate([
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'old_password' => 'nullable', 
            'new_password' => 'nullable|string|min:8'
        ]);
        $validatedAcademician = $request->validate([
            'college' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
        ]);
    
        if ($request->filled('old_password')) {
            if (!Hash::check($request->old_password, $user->password)) {
                return back()->withErrors(['old_password' => 'The current password is incorrect.']);
            }
        }
    
        if ($request->filled('new_password')) {
            $user->password = bcrypt($request->new_password);
        }
    
        if ($request->hasFile('profile_picture') && $request->file('profile_picture')->isValid()) {
            $imagePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $validatedData['profile_picture'] = $imagePath;
        } else {
            unset($validatedData['profile_picture']);
        }
    
        $user->update($validatedData);
        if ($user->academician) {
            $user->academician->update([
                'college' => $validatedAcademician['college'],
                'department' => $validatedAcademician['department'],
                'position' => $validatedAcademician['position'],
            ]);
        }
    
        return redirect()->route('user.edit')->with('success', 'Profile updated successfully.');
    }
    
}
