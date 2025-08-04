<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SiteSetting;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SiteSettingController extends Controller
{
    /**
     * Tampilkan form pengaturan tampilan publik
     */
    public function edit()
    {
        $setting = SiteSetting::first() ?? new SiteSetting();
        return view('admin.setting', compact('setting'));
    }

    /**
     * Simpan perubahan pengaturan
     */
    public function update(Request $request)
    {
        $setting = SiteSetting::first();

        // ✅ Validasi input
        $validator = Validator::make($request->all(), [
            'judul' => 'nullable|string|max:100',
            'subjudul' => 'nullable|string|max:100',
            'alamat' => 'nullable|string',
            'telepon' => 'nullable|string|max:30',
            'email' => 'nullable|string|max:255',
            'tahukah_kamu' => 'nullable|string',
            'deskripsi_iph' => 'nullable|string', // CKEditor HTML
            'logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'logo_berakhlak' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'logo_iph' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // ✅ Ambil data teks
        $data = $request->only([
            'judul',
            'subjudul',
            'alamat',
            'telepon',
            'email',
            'tahukah_kamu',
            'deskripsi_iph',
        ]);

        // ✅ Handle upload logo
        foreach (['logo', 'logo_berakhlak', 'logo_iph'] as $field) {
            if ($request->hasFile($field)) {
                // Hapus logo lama jika ada
                if ($setting && $setting->$field) {
                    Storage::disk('public')->delete($setting->$field);
                }
                // Simpan logo baru
                $data[$field] = $request->file($field)->store('images', 'public');
            }
        }

        // ✅ Simpan ke database
        SiteSetting::updateOrCreate(
            ['id' => $setting?->id ?? 1],
            $data
        );

        // ✅ Cache untuk preview logo (opsional)
        cache()->put('hide_logo_admin_preview', true, now()->addMinutes(3));

        // ✅ Redirect dengan pesan sukses
        return redirect()->route('admin.setting.edit')->with('success', '✅ Pengaturan berhasil disimpan!');
    }
}
