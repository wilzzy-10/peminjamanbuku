<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::paginate(20);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'role' => 'required|in:member,admin,petugas',
            'status' => 'required|in:active,inactive',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil ditambahkan');
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);
        
        // Get loan statistics for the user
        $activeLoans = $user->loans()->where('status', 'active')->with('book')->get();
        $returnedLoans = $user->loans()->where('status', 'returned')->with('book')->get();
        $overdueLoans = $user->loans()->where('status', 'active')
                                    ->where('due_date', '<', now())
                                    ->with('book')
                                    ->get();
        
        return view('user.profile', compact('user', 'activeLoans', 'returnedLoans', 'overdueLoans'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->authorize('update', $user);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'role' => 'required|in:member,admin,petugas',
            'status' => 'required|in:active,inactive',
        ]);

        // Remove password from validated array if empty or not provided
        if (empty($validated['password'])) {
            unset($validated['password']);
        } else {
            $validated['password'] = bcrypt($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('profile.show', $user)->with('success', 'Profil berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        if ($user->loans()->where('status', 'active')->count() > 0) {
            return redirect()->route('users.index')->with('error', 'Pengguna tidak dapat dihapus karena masih memiliki peminjaman aktif');
        }

        $user->delete();
        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus');
    }
}

