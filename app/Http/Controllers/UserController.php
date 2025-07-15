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
    /* ───────────── AJAX: DataTables request ───────────── */
    if ($request->ajax()) {
        // ⬇ join regions so we can order / search on region name
        $users = User::query()
            ->leftJoin('regions', 'regions.id', '=', 'users.region_id')
            ->select([
                'users.id',
                'users.fullname',
                'users.username',
                'users.email',
                'users.user_type',
                'regions.name as region',      // alias as "region" for JSON key
                'users.created_at',
            ]);

        return DataTables::of($users)
            ->addIndexColumn()                     // DT_RowIndex
            ->editColumn('created_at', fn ($row)   // nice date format
                => $row->created_at->format('Y-m-d H:i'))
            ->addColumn('action', function ($row) { // buttons / dropdown
                return view('pages.users.actions', compact('row'))->render();
            })
            ->rawColumns(['action'])               // allow HTML in “action”
            ->make(true);
    }

    /* ───────────── First page load: Blade view ───────────── */
    $regions   = Region::orderBy('name')->get(['id', 'name']);
    $userTypes = ['admin', 'market_officer', 'general'];

    return view('pages.users.index', compact('regions', 'userTypes'));
}


    /* ───────────── Create ───────────── */
    public function create()
    {
        $regions = Region::orderBy('name')->get();
        return view('pages.users.create', compact('regions'));
    }

    /* ───────────── Store ───────────── */
    public function store(Request $request)
    {
        $request->validate([
            'fullname'   => 'required|string|max:255',
            'username'   => 'required|string|max:100|unique:users,username',
            'email'      => 'required|email|unique:users,email',
            'user_type'  => ['required', Rule::in(['admin', 'market_officer', 'general'])],
            'region_id'  => 'nullable|exists:regions,id',
            'password'   => 'required|string|min:6|confirmed',
        ]);

        User::create([
            'fullname'   => $request->fullname,
            'username'   => $request->username,
            'email'      => $request->email,
            'user_type'  => $request->user_type,
            'region_id'  => $request->region_id,
            'password'   => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'User created.');
    }

    /* ───────────── Edit ───────────── */
    public function edit($id)
    {
        $user    = User::findOrFail($id);
        $regions = Region::orderBy('name')->get();

        return view('pages.users.edit', compact('user', 'regions'));
    }

    /* ───────────── Update ───────────── */
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
            'user_type'  => ['required', Rule::in(['admin', 'market_officer', 'general'])],
            'region_id'  => 'nullable|exists:regions,id',
            'password'   => 'nullable|string|min:6|confirmed',
        ]);

        $user->update([
            'fullname'   => $request->fullname,
            'username'   => $request->username,
            'email'      => $request->email,
            'user_type'  => $request->user_type,
            'region_id'  => $request->region_id,
            'password'   => $request->filled('password') ? Hash::make($request->password) : $user->password,
        ]);

        return redirect()->route('users.index')->with('success', 'User updated.');
    }

    /* ───────────── Destroy ───────────── */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users.index')->with('success', 'User deleted.');
    }
}
