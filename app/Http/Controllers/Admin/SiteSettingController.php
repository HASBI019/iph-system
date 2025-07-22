<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SiteSettingController extends Controller
{
    public function edit()
    {
        $setting = SiteSetting::first() ?? new SiteSetting();
        return view('admin.setting', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = SiteSetting::first();

        $validator = Validator::make($request->all(), [
            'judul' => 'nullable|string|max:100',
            'subjudul' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:30',
            'email' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'logo_berakhlak' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'logo_iph' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

       $data = $request->only([
    'judul', 'subjudul', 'alamat', 'telepon', 'email', 'tahukah_kamu'
]);

        foreach (['logo', 'logo_berakhlak', 'logo_iph'] as $field) {
            if ($request->hasFile($field)) {
                if ($setting && $setting->$field) {
                    Storage::disk('public')->delete($setting->$field);
                }
                $data[$field] = $request->file($field)->store('images', 'public');
            }
        }

        SiteSetting::updateOrCreate(['id' => $setting?->id ?? 1], $data);

        // ✅ Simpan status hide ke cache (aktif selama 3 menit)
        cache()->put('hide_logo_admin_preview', true, now()->addMinutes(3));

        return redirect()->route('admin.setting.edit')->with('success', '✅ Pengaturan berhasil disimpan!');
    }
}
