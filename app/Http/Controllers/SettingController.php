<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function get()
    {
        return response()->json(Setting::first());
    }

    public function update(Request $request)
    {
        if ($request->wantsJson()) {
            $request->validate([
                'name' => 'nullable',
                'description' => 'nullable',
                'logo' => 'nullable|file|mimes:jpg,png,jpeg',
                'email' => 'nullable|email',
                'phone' => 'nullable'
            ]);

            $setting = Setting::first();

            if ($setting->logo != null && $setting->logo != '') {
                $old_photo = str_replace('/storage/', '', $setting->logo);
                Storage::disk('public')->delete($old_photo);
            }

            $data = $request->all();

            if ($request->hasFile('logo')) {
                $data['logo'] = '/storage/' . $request->file('logo')->store('setting', 'public');
            }

            $setting->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Success update Web Config'
            ]);
        } else {
            abort(404);
        }
    }
}
