<?php

namespace App\Http\Controllers;

use App\Models\WebsiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebsiteSettingController extends Controller
{
    public function index()
    {
        $setting = WebsiteSetting::first();
        return view('website_setting.index', compact('setting'));
    }

    public function saveOrUpdate(Request $request)
    {
        $request->validate([
            'web_name' => 'required|string|max:255',
            'web_description' => 'required|string|max:255',
            'web_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'web_favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'irvan_url' => 'required|string|max:255',
            'irvan_app_id' => 'required|string|max:255',
            'irvan_app_key' => 'required|string|max:255',
        ]);
    
        $setting = WebsiteSetting::firstOrNew(['id' => 1]);
    
        $setting->web_name = $request->web_name;
        $setting->web_description = $request->web_description;
        $setting->irvan_url = $request->irvan_url;
        $setting->irvan_app_id = $request->irvan_app_id;
        $setting->irvan_app_key = $request->irvan_app_key;
    
        if ($request->hasFile('web_logo')) {
            if ($setting->web_logo) {
                Storage::disk('public')->delete($setting->web_logo);
            }
            $setting->web_logo = $request->file('web_logo')->store('logos', 'public');
        }
    
        if ($request->hasFile('web_favicon')) {
            if ($setting->web_favicon) {
                Storage::disk('public')->delete($setting->web_favicon);
            }
            $setting->web_favicon = $request->file('web_favicon')->store('favicons', 'public');
        }
    
        $setting->save();
    
        return redirect()->back()->with('success', 'Website settings updated successfully!');
    }
    
}
