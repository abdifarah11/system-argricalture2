<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $users = User::query()
                ->leftJoin('regions', 'regions.id', '=', 'users.region_id')
                ->select([
                    'users.id',
                    'users.fullname',
                    'users.username',
                    'users.email',
                    'users.role',
                    'regions.name as region',
                    'users.created_at',
                ]);

            return DataTables::of($users)
                ->addIndexColumn()
                ->editColumn('created_at', fn($row) => $row->created_at->format('Y-m-d H:i'))
                ->addColumn('action', function ($row) {
                    return view('pages.users.actions', compact('row'))->render();
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $regions   = Region::orderBy('name')->get(['id', 'name']);
        $userTypes = ['admin', 'market_officer', 'general'];

        return view('pages.users.index', compact('regions', 'userTypes'));
    }

    public function create()
    {
        $regions = Region::orderBy('name')->get();
        return view('pages.users.create', compact('regions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'fullname'   => 'required|string|max:255',
            'username'   => 'required|string|max:100|unique:users,username',
            'email'      => 'required|email|unique:users,email',
            'role'       => ['required', Rule::in(['admin', 'market_officer', 'general'])],
            'region_id'  => 'nullable|exists:regions,id',
            'password'   => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'fullname'   => $request->fullname,
            'username'   => $request->username,
            'email'      => $request->email,
            'role'       => $request->role,
            'region_id'  => $request->region_id,
            'password'   => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User created.');
    }

    public function edit($id)
    {
        $user    = User::findOrFail($id);
        $regions = Region::orderBy('name')->get();

        return view('pages.users.edit', compact('user', 'regions'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'fullname'   => 'required|string|max:255',
            'username'   => [
                'required', 'string', 'max:100',
                Rule::unique('users', 'username')->ignore($user->id),
            ],
            'email'      => [
                'required', 'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'role'       => ['required', Rule::in(['admin', 'market_officer', 'general'])],
            'region_id'  => 'nullable|exists:regions,id',
            'password'   => 'nullable|string|min:6|confirmed',
        ]);

        $user->update([
            'fullname'   => $request->fullname,
            'username'   => $request->username,
            'email'      => $request->email,
            'role'       => $request->role,
            'region_id'  => $request->region_id,
            'password'   => $request->filled('password') ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated.');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted.');
    }

    /* ───────────── ADMIN RESET PASSWORD (NO EMAIL) ───────────── */
   public function resetPasswor($id)
{
    // Check if current user is admin
    if (auth()->user()->role !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

    $user = User::findOrFail($id);
    return view('pages.users.reset-password', compact('user'));
}

// public function changePassword(Request $request, $id)
// {
//     // Check if current user is admin
//     if (auth()->user()->role !== 'admin') {
//         abort(403, 'Unauthorized action.');
//     }

//     $request->validate([
//         'password' => 'required|string|min:6|confirmed',
//     ]);

//     $user = User::findOrFail($id);
//     $user->password = Hash::make($request->password);
//     $user->save();

//     return redirect()->route('users.index')->with('success', 'Password reset successfully.');
// }
public function showChangePasswordForm($id)
{
    $authUser = auth()->user();

    if ($authUser->role !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

    $user = User::findOrFail($id);

    $allowedRoles = ['customer', 'general_officer'];

    if (!in_array($user->role, $allowedRoles)) {
        abort(403, 'You cannot change the password for this user.');
    }

    return view('pages.users.changepassword', compact('user'));
}

public function changepassword(Request $request, $id)
{
    $authUser = auth()->user();

    if ($authUser->role !== 'admin') {
        abort(403, 'Unauthorized action.');
    }

    $user = User::findOrFail($id);

    $allowedRoles = ['customer', 'general_officer'];

    if (!in_array($user->role, $allowedRoles)) {
        abort(403, 'You cannot change the password for this user.');
    }

    $request->validate([
        'password' => 'required|string|min:6|confirmed',
    ]);

    $user->password = Hash::make($request->password);
    $user->save();

    return redirect()->route('users.index')->with('success', 'Password updated successfully.');
}



}
