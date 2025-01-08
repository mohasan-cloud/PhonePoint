<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminSetting;

class AdminSettingController extends Controller
{
    public function createOrUpdate()
    {
        $setting = AdminSetting::first(); // Fetch the first setting entry or null
        return view('admin.settings.create_or_update', compact('setting'));
    }

    public function storeOrUpdate(Request $request)
    {

        $request->validate([
            'site_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:500', // Increased max length for textarea
            'email_1' => 'nullable|email|string|max:255',
            'email_2' => 'nullable|email|string|max:255',
            'email_3' => 'nullable|email|string|max:255',
            'phone_1' => 'nullable|string|max:255',
            'phone_2' => 'nullable|string|max:255',
            'phone_3' => 'nullable|string|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'Instagram' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'tiktok' => 'nullable|string|max:255',

            'favicon' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'footer_logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'site_name', 'address', 'email_1', 'email_2', 'email_3',
            'phone_1', 'phone_2', 'phone_3','facebook','twitter','Instagram','linkedin','youtube','tiktok'
        ]);

        // Handle Favicon Upload
        if ($request->hasFile('favicon')) {
            $favicon = $request->file('favicon');
            $faviconName = 'favicon_' . time() . '.' . $favicon->getClientOriginalExtension();
            $favicon->move(public_path('images'), $faviconName);
            $data['favicon'] = 'images/' . $faviconName;
        }

        // Handle Logo Upload
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $logoName = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images'), $logoName);
            $data['logo'] = 'images/' . $logoName;
        }

        // Handle Footer Logo Upload
        if ($request->hasFile('footer_logo')) {
            $footer_logo = $request->file('footer_logo');
            $footer_logoName = 'footer_logo_' . time() . '.' . $footer_logo->getClientOriginalExtension();
            $footer_logo->move(public_path('images'), $footer_logoName);
            $data['footer_logo'] = 'images/' . $footer_logoName;
        }

        // Create or update the settings
        AdminSetting::updateOrCreate(['id' => 1], $data);

        return redirect()->route('admin.settings.createOrUpdate') // Ensure this route exists
                         ->with('success', 'Settings saved successfully!');
    }


}
