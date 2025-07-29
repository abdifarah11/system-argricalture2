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

    public function edit(Setting $setting)
    {
        return view('pages.settings.edit', compact('setting'));
    }

    public function update(Request $request, Setting $setting)
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
            if ($setting->logo_path && Storage::disk('public')->exists($setting->logo_path)) {
                Storage::disk('public')->delete($setting->logo_path);
            }
            $validated['logo_path'] = $request->file('logo')->store('logos', 'public');
        }

        $setting->update($validated);

        return redirect()->route('settings.index')->with('success', 'Setting updated successfully.');
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
