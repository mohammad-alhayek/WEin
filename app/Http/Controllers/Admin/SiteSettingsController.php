<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSettings;
use Illuminate\Http\Request;

class SiteSettingsController extends Controller
{
    public function index()
    {
        $settings = SiteSettings::get();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'site_name'   => 'required|string|max:60',
            'admin_name'  => 'nullable|string|max:100',
            'admin_phone' => 'nullable|string|max:30',
        ]);

        $settings = SiteSettings::get();
        $settings->update($data);

        return back()->with('success', __('messages.settings_saved'));
    }
}
