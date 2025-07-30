<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view('pages.settings.index', compact('setting'));
    }

    public function create()
    {
        return view('pages.settings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'system_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'location' => 'nullable|url',
            'email' => 'nullable|email',
            'url' => 'nullable|url',
            'whatsapp' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo_path'] = $request->file('logo')->store('logos', 'public');
        }

        Setting::create($validated);

        return redirect()->route('settings.index')->with('success', 'Setting created successfully.');
    }

   public function edit($id)
{
    $setting = Setting::findOrFail($id);
    return view('pages.settings.edit', compact('setting'));
}

public function update(Request $request, $id)
{
    $setting = Setting::findOrFail($id);

    $request->validate([
        'system_name' => 'required',
        'email' => 'required|email',
        'phone' => 'nullable',
        'address' => 'nullable',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = $request->only(['system_name', 'email', 'phone', 'address', ]);

    if ($request->hasFile('logo')) {
        $data['logo'] = $request->file('logo')->store('logos', 'public');
    }

    $setting->update($data);

    return redirect()->route('settings.index')->with('success', 'System settings updated successfully.');
}

    

    public function destroy(Setting $setting)
    {
        if ($setting->logo_path && Storage::disk('public')->exists($setting->logo_path)) {
            Storage::disk('public')->delete($setting->logo_path);
        }

        $setting->delete();

        return redirect()->route('settings.index')->with('success', 'Setting deleted successfully.');
    }
}
