<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key');
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'nullable|string|max:255',
            'site_address' => 'nullable|string|max:500',
            'contact_email' => 'nullable|email|max:255',
            'site_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->has('site_name')) {
            Setting::updateOrCreate(['key' => 'site_name'], ['value' => $request->site_name]);
        }

        if ($request->has('site_address')) {
            Setting::updateOrCreate(['key' => 'site_address'], ['value' => $request->site_address]);
        }

        if ($request->has('contact_email')) {
            Setting::updateOrCreate(['key' => 'contact_email'], ['value' => $request->contact_email]);
        }

        if ($request->hasFile('site_logo')) {
            // Delete old logo if exists
            $oldLogo = Setting::get('site_logo');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }

            $path = $request->file('site_logo')->store('settings', 'public');
            Setting::updateOrCreate(['key' => 'site_logo'], ['value' => $path]);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}
