<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Models\Site;
use App\Models\Setting;
use DataTables;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{

    public function index()
    {
        $setting = Setting::first();
        $sites = Site::latest()->get();
        return view('setting.index', compact('setting', 'sites'));
    }

    public function update(Request $request)
    {
        $id = $request->id;
        $site = Setting::findOrFail($id);
        if ($request->hasFile('site_logo')) {
            if ($site->site_logo) {
                Storage::delete('uploads/site/' . $site->site_logo);
            }

            $file = $request->file('site_logo');
            $site_logo = $request->site_name . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move("uploads/site/", $site_logo);

            $site->site_logo = $site_logo;
        }

        $site->site_name = $request->site_name ?? '';
        $site->site_url = $request->site_url ?? '';
        $site->site_type = $request->site_type ?? '';
        $site->default_site_id = $request->default_site_id ?? '';
        $site->header_script = $request->header_script ?? '';
        $site->footer_script = $request->footer_script ?? '';
        $site->header_style = $request->header_style ?? '';
        $site->ads = $request->ads ?? '';
        $site->status = $request->status ?? '';
        $site->save();

        $setting = Setting::first();
        $sites = Site::latest()->get();
        return redirect()->route('setting.index', compact('setting', 'sites'))
            ->with('success', 'setting updated successfully.');
    }
}
