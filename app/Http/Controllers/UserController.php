<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    // ADMIN ONLY: VIEW ALL USERS
    public function index()
    {
        $users = User::all()
            ->sortBy('name')
            ->values();

        $totalUsers = $users->count();

        $totalAdmins = $users->filter(function ($user) {
            return in_array(
                strtolower(trim($user->role ?? '')),
                ['admin', 'administrator']
            );
        })->count();

        $totalStaff = $users->filter(function ($user) {
            return strtolower(trim($user->role ?? '')) === 'staff';
        })->count();

        $totalTeachers = $users->filter(function ($user) {
            return strtolower(trim($user->role ?? '')) === 'teacher';
        })->count();

        $totalStudents = $users->filter(function ($user) {
            return strtolower(trim($user->role ?? '')) === 'student';
        })->count();

        return view('users.index', compact(
            'users',
            'totalUsers',
            'totalAdmins',
            'totalStaff',
            'totalTeachers',
            'totalStudents'
        ));
    }

    // SHOW CREATE USER FORM
    public function create()
    {
        return view('users.create');
    }

    // CREATE USER
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('mongodb.users', 'email'),
            ],

            'role' => [
                'required',
                Rule::in(['staff', 'teacher']),
            ],

            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'role' => $validated['role'],
        ]);

        return redirect()
            ->route('users.index')
            ->with('success', 'User account created successfully.');
    }

    // SHOW EDIT USER FORM
    public function edit(string $id)
    {
        $user = User::findOrFail($id);

        return view('users.edit', compact('user'));
    }

    // UPDATE USER
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('mongodb.users', 'email')
                    ->ignore($user->getKey(), '_id'),
            ],

            'role' => [
                'required',
                Rule::in([
                    'admin',
                    'administrator',
                    'staff',
                    'teacher',
                    'student'
                ]),
            ],

            'password' => [
                'nullable',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        $user->name = $validated['name'];
        $user->email = $validated['email'];

        // Prevent changing your own administrator role.
        if ((string) $user->getKey() === (string) auth()->id()) {
            if (!in_array(
                strtolower($validated['role']),
                ['admin', 'administrator']
            )) {
                return back()
                    ->withInput()
                    ->with('error', 'You cannot change your own administrator role.');
            }
        }

        $user->role = $validated['role'];

        if (!empty($validated['password'])) {
            $user->password = $validated['password'];
        }

        $user->save();

        return redirect()
            ->route('users.index')
            ->with('success', 'User account updated successfully.');
    }

    // DELETE USER
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Prevent deleting your own account.
        if ((string) $user->getKey() === (string) auth()->id()) {
            return back()->with(
                'error',
                'You cannot delete your own account.'
            );
        }

        // Protect administrator accounts.
        if (in_array(
            strtolower(trim($user->role ?? '')),
            ['admin', 'administrator']
        )) {
            return back()->with(
                'error',
                'Administrator accounts cannot be deleted here.'
            );
        }

        $user->delete();

        return redirect()
            ->route('users.index')
            ->with('success', 'User account deleted successfully.');
    }
}
