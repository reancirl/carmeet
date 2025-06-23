<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(AdminMiddleware::class);
    }

    /**
     * Display a listing of users with filters.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Filter by role
        if ($request->has('role') && in_array($request->role, ['admin', 'organizer', 'attendee', 'registrant'])) {
            $query->where('role', $request->role);
        }

        // Filter by approval status
        if ($request->has('approval_status')) {
            if ($request->approval_status === 'approved') {
                $query->where('is_admin_approved', true);
            } elseif ($request->approval_status === 'pending') {
                $query->where('is_admin_approved', false);
            }
        }

        // Search by name or email
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $users = $query->where('id', '!=', 1)->latest()->paginate(15);
        
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // 'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role' => ['required', 'in:admin,organizer,attendee,registrant'],
            'is_admin_approved' => ['boolean'],
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('status', 'User updated successfully');
    }

    /**
     * Approve a user.
     */
    public function approve(User $user)
    {
        $user->update(['is_admin_approved' => true]);
        
        return back()->with('status', 'User approved successfully');
    }

    /**
     * Reject a user.
     */
    public function reject(User $user)
    {
        $user->update(['is_admin_approved' => false]);
        
        return back()->with('status', 'User rejected');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account');
        }

        $user->delete();

        return back()->with('status', 'User deleted successfully');
    }
}
