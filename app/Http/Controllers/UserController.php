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
                    // 'users.username',
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
            'email'      => 'required|email|unique:users,email',
            'role'       => ['required', Rule::in(['admin', 'market_officer', 'general'])],
            'region_id'  => 'nullable|exists:regions,id',
            'password'   => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'fullname'   => $request->fullname,
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
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id);
        return view('pages.users.changepassword', compact('user'));
    }

    public function showChangePasswordForm($id)
    {
        $authUser = auth()->user();

        if ($authUser->role !== 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $user = User::findOrFail($id);

        $allowedRoles = ['customer', 'market_officer','general'];

        if (!in_array($user->role, $allowedRoles)) {
            abort(403, 'You cannot change the password for this user.');
        }

        return view('pages.users.changepassword', compact('user'));
    }

    // New improved changePassword method with 403 block and error page response
    public function changePassword(Request $request, $userId)
    {
        $currentUser = auth()->user();
        $targetUser = User::findOrFail($userId);

        // Block if target user is admin and current user is not admin
        if ($targetUser->role === 'admin' && $currentUser->role !== 'admin') {
            // Return 403 view with custom button
            return response()->view('pages.users.errors.403', [], 403);
        }

        $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        $targetUser->password = Hash::make($request->password);
        $targetUser->save();

        return redirect()->route('users.index')->with('success', 'Password updated successfully.');
    }
}
