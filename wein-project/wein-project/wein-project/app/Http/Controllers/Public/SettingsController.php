<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('public.settings');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'theme'    => 'nullable|in:light,dark',
            'language' => 'nullable|in:en,ar',
            'view'     => 'nullable|in:card,list',
        ]);

        $response = back()->with('success', __('messages.settings_saved'));

        if (!empty($data['theme'])) {
            $response = $response->cookie('wein_theme', $data['theme'], 60 * 24 * 365);
        }
        if (!empty($data['language'])) {
            session(['locale' => $data['language']]);
            $response = $response->cookie('wein_lang', $data['language'], 60 * 24 * 365);
            app()->setLocale($data['language']);
        }
        if (!empty($data['view'])) {
            $response = $response->cookie('wein_view', $data['view'], 60 * 24 * 365);
        }

        return $response;
    }

    public function language(Request $request)
    {
        $lang = $request->validate(['lang' => 'required|in:en,ar'])['lang'];
        session(['locale' => $lang]);
        return back()->cookie('wein_lang', $lang, 60 * 24 * 365);
    }
}
