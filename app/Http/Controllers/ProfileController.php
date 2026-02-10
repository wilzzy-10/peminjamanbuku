<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        
        // Get loan statistics
        $activeLoans = $user->loans()->where('status', 'active')->with('book')->get();
        $returnedLoans = $user->loans()->where('status', 'returned')->with('book')->get();
        $overdueLoans = $user->loans()->where('status', 'active')
                                    ->where('due_date', '<', now())
                                    ->with('book')
                                    ->get();
        
        return view('user.profile', compact('user', 'activeLoans', 'returnedLoans', 'overdueLoans'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('user.profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Remove password if not provided
        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = bcrypt($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('profile.show')->with('success', 'Profil berhasil diperbarui');
    }
}
