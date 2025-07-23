<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IphMingguan;
use App\Models\IphBulanan;

class IphController extends Controller
{
    // Form Input
    public function inputMingguan()
    {
        return view('admin.form_mingguan');
    }

    public function inputBulanan()
    {
        return view('admin.form_bulanan');
    }

    // Simpan Data
    public function saveMingguan(Request $request)
    {
        $data = $request->validate([
            'tahun' => 'required|integer',
            'bulan' => 'required|string',
            'minggu_ke' => 'required|integer',
            'perubahan_harga' => 'required|numeric',
            'fluktuasi_tertinggi' => 'nullable|string',
            'nama_komoditas_1' => 'nullable|string',
            'nilai_andil_1' => 'nullable|numeric',
            'nama_komoditas_2' => 'nullable|string',
            'nilai_andil_2' => 'nullable|numeric',
            'nama_komoditas_3' => 'nullable|string',
            'nilai_andil_3' => 'nullable|numeric',
            'nama_komoditas_4' => 'nullable|string',
            'nilai_andil_4' => 'nullable|numeric',
            'nama_komoditas_5' => 'nullable|string',
            'nilai_andil_5' => 'nullable|numeric',
            'disparitas_harga' => 'nullable|numeric',
            'nilai_fluktuasi' => 'nullable|numeric',
        ]);

        $data['status_harga'] = $this->statusHarga($data['perubahan_harga']);

        IphMingguan::create($data);

        return redirect()->back()->with('success', 'Data IPH Mingguan berhasil disimpan.');
    }

    public function saveBulanan(Request $request)
    {
        $data = $request->validate([
            'tahun' => 'required|integer',
            'bulan' => 'required|string',
            'perubahan_harga' => 'required|numeric',
            'fluktuasi_tertinggi' => 'nullable|string',
            'nama_komoditas_1' => 'nullable|string',
            'nilai_andil_1' => 'nullable|numeric',
            'nama_komoditas_2' => 'nullable|string',
            'nilai_andil_2' => 'nullable|numeric',
            'nama_komoditas_3' => 'nullable|string',
            'nilai_andil_3' => 'nullable|numeric',
            'nama_komoditas_4' => 'nullable|string',
            'nilai_andil_4' => 'nullable|numeric',
            'nama_komoditas_5' => 'nullable|string',
            'nilai_andil_5' => 'nullable|numeric',
            'disparitas_harga' => 'nullable|numeric',
            'nilai_fluktuasi' => 'nullable|numeric',
        ]);

        $data['status_harga'] = $this->statusHarga($data['perubahan_harga']);

        IphBulanan::create($data);

        return redirect()->back()->with('success', 'Data IPH Bulanan berhasil disimpan.');
    }

    // Tampilkan Data
    public function viewMingguan(Request $request)
    {
        $data = IphMingguan::query()
            ->when($request->tahun, fn($q) => $q->where('tahun', $request->tahun))
            ->when($request->bulan, fn($q) => $q->where('bulan', $request->bulan))
            ->orderByDesc('created_at')
            ->get();

        return view('admin.view_mingguan', compact('data'));
    }

    public function viewBulanan(Request $request)
    {
        $data = IphBulanan::query()
            ->when($request->tahun, fn($q) => $q->where('tahun', $request->tahun))
            ->when($request->bulan, fn($q) => $q->where('bulan', $request->bulan))
            ->orderByDesc('created_at')
            ->get();

        return view('admin.view_bulanan', compact('data'));
    }

    // Edit Data
    public function editMingguan($id)
    {
        $data = IphMingguan::findOrFail($id);
        return view('admin.edit_mingguan', compact('data'));
    }

    public function editBulanan($id)
    {
        $data = IphBulanan::findOrFail($id);
        return view('admin.edit_bulanan', compact('data'));
    }

    // Update Data
    public function updateMingguan(Request $request, $id)
    {
        $data = $request->validate([
            'tahun' => 'required|integer',
            'bulan' => 'required|string',
            'minggu_ke' => 'required|integer',
            'perubahan_harga' => 'required|numeric',
            'fluktuasi_tertinggi' => 'nullable|string',
            'nama_komoditas_1' => 'nullable|string',
            'nilai_andil_1' => 'nullable|numeric',
            'nama_komoditas_2' => 'nullable|string',
            'nilai_andil_2' => 'nullable|numeric',
            'nama_komoditas_3' => 'nullable|string',
            'nilai_andil_3' => 'nullable|numeric',
            'nama_komoditas_4' => 'nullable|string',
            'nilai_andil_4' => 'nullable|numeric',
            'nama_komoditas_5' => 'nullable|string',
            'nilai_andil_5' => 'nullable|numeric',
            'disparitas_harga' => 'nullable|numeric',
            'nilai_fluktuasi' => 'nullable|numeric',
        ]);

        $data['status_harga'] = $this->statusHarga($data['perubahan_harga']);

        IphMingguan::findOrFail($id)->update($data);

        return redirect()->route('iph-mingguan.index')->with('success', 'Data IPH Mingguan berhasil diperbarui.');
    }

    public function updateBulanan(Request $request, $id)
    {
        $data = $request->validate([
            'tahun' => 'required|integer',
            'bulan' => 'required|string',
            'perubahan_harga' => 'required|numeric',
            'fluktuasi_tertinggi' => 'nullable|string',
            'nama_komoditas_1' => 'nullable|string',
            'nilai_andil_1' => 'nullable|numeric',
            'nama_komoditas_2' => 'nullable|string',
            'nilai_andil_2' => 'nullable|numeric',
            'nama_komoditas_3' => 'nullable|string',
            'nilai_andil_3' => 'nullable|numeric',
            'nama_komoditas_4' => 'nullable|string',
            'nilai_andil_4' => 'nullable|numeric',
            'nama_komoditas_5' => 'nullable|string',
            'nilai_andil_5' => 'nullable|numeric',
            'disparitas_harga' => 'nullable|numeric',
            'nilai_fluktuasi' => 'nullable|numeric',
        ]);

        $data['status_harga'] = $this->statusHarga($data['perubahan_harga']);

        IphBulanan::findOrFail($id)->update($data);

        return redirect()->route('iph-bulanan.index')->with('success', 'Data IPH Bulanan berhasil diperbarui.');
    }

    // Hapus Data
    public function deleteMingguan($id)
    {
        IphMingguan::destroy($id);
        return redirect()->back()->with('success', 'Data IPH Mingguan berhasil dihapus.');
    }

    public function deleteBulanan($id)
    {
        IphBulanan::destroy($id);
        return redirect()->back()->with('success', 'Data IPH Bulanan berhasil dihapus.');
    }

    // Status Harga Otomatis
    private function statusHarga($value)
    {
        return $value > 0 ? 'Naik' : ($value < 0 ? 'Turun' : 'Stabil');
    }
}
