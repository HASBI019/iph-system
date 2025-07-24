<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IphMingguan;
use App\Models\IphBulanan;
use App\Models\SiteSetting;

class IphController extends Controller
{
    // ================================
    // Form Input
    // ================================
    public function inputMingguan()
    {
        return view('admin.form_mingguan');
    }

    public function inputBulanan()
    {
        return view('admin.form_bulanan');
    }

    // ================================
    // Simpan Data
    // ================================
    public function saveMingguan(Request $request)
    {
        $raw = $request->all();
        $this->parseDecimalFields($raw);

        $data = validator($raw, $this->rulesMingguan())->validate();
        $data['status_harga'] = $this->statusHarga($data['perubahan_harga']);
        IphMingguan::create($data);

        return redirect()->back()->with('success', 'Data IPH Mingguan berhasil disimpan.');
    }

    public function saveBulanan(Request $request)
    {
        $raw = $request->all();
        $this->parseDecimalFields($raw);

        $data = validator($raw, $this->rulesBulanan())->validate();
        $data['status_harga'] = $this->statusHarga($data['perubahan_harga']);
        IphBulanan::create($data);

        return redirect()->back()->with('success', 'Data IPH Bulanan berhasil disimpan.');
    }

    // ================================
    // Edit Data
    // ================================
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

    // ================================
    // Update Data
    // ================================
    public function updateMingguan(Request $request, $id)
    {
        $raw = $request->all();
        $this->parseDecimalFields($raw);

        $data = validator($raw, $this->rulesMingguan())->validate();
        $data['status_harga'] = $this->statusHarga($data['perubahan_harga']);
        IphMingguan::findOrFail($id)->update($data);

        return redirect()->route('iph-mingguan.index')->with('success', 'Data IPH Mingguan berhasil diperbarui.');
    }

    public function updateBulanan(Request $request, $id)
    {
        $raw = $request->all();
        $this->parseDecimalFields($raw);

        $data = validator($raw, $this->rulesBulanan())->validate();
        $data['status_harga'] = $this->statusHarga($data['perubahan_harga']);
        IphBulanan::findOrFail($id)->update($data);

        return redirect()->route('iph-bulanan.index')->with('success', 'Data IPH Bulanan berhasil diperbarui.');
    }

    // ================================
    // Tampilkan Data
    // ================================
   public function viewMingguan(Request $request)
{
    $orderBulan = ['Januari','Februari','Maret','April','Mei','Juni',
                   'Juli','Agustus','September','Oktober','November','Desember'];

    $data = IphMingguan::query()
        ->when($request->tahun, fn($q) => $q->where('tahun', $request->tahun))
        ->when($request->bulan, fn($q) => $q->where('bulan', $request->bulan))
        ->orderBy('tahun', 'asc')
        ->orderByRaw("FIELD(bulan, '" . implode("','", $orderBulan) . "')")
        ->orderBy('minggu_ke', 'asc') 
        ->get();

    return view('admin.view_mingguan', compact('data'));
}


    public function viewBulanan(Request $request)
{
    $orderBulan = ['Januari','Februari','Maret','April','Mei','Juni',
                   'Juli','Agustus','September','Oktober','November','Desember'];

    $data = IphBulanan::query()
        ->when($request->tahun, fn($q) => $q->where('tahun', $request->tahun))
        ->when($request->bulan, fn($q) => $q->where('bulan', $request->bulan))
        ->orderBy('tahun', 'asc')
        ->orderByRaw("FIELD(bulan, '" . implode("','", $orderBulan) . "') ASC") 
        ->get();

    return view('admin.view_bulanan', compact('data'));
}



    // ================================
    // Hapus Data
    // ================================
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

    // ================================
    // Status Harga Otomatis
    // ================================
    private function statusHarga($value)
    {
        return $value > 0 ? 'Naik' : ($value < 0 ? 'Turun' : 'Stabil');
    }

    // ================================
    // Helper: Parsing angka dengan koma
    // ================================
    private function parseDecimalFields(&$data)
{
    foreach ($data as $key => $value) {
        if (preg_match('/^(perubahan_harga|disparitas_harga|nilai_fluktuasi|nilai_andil_\d+)$/', $key)) {
            $clean = str_replace(',', '.', $value);
            $clean = rtrim(rtrim($clean, '0'), '.'); // ⬅️ Buang nol belakang & titik
            $data[$key] = $clean === '' ? null : $clean;
        }
    }
}

        // ================================
        // view tabel ke frontend
        // ================================
        public function beranda(Request $request)
{
    $orderBulan = ['Januari','Februari','Maret','April','Mei','Juni',
                   'Juli','Agustus','September','Oktober','November','Desember'];

    $bulanan = IphBulanan::query()
        ->when($request->tahun, fn($q) => $q->where('tahun', $request->tahun))
        ->when($request->bulan, fn($q) => $q->where('bulan', $request->bulan))
        ->orderBy('tahun', 'asc')
        ->orderByRaw("FIELD(bulan, '" . implode("','", $orderBulan) . "')")
        ->get();

    $mingguan = IphMingguan::query()
        ->when($request->tahun, fn($q) => $q->where('tahun', $request->tahun))
        ->when($request->bulan, fn($q) => $q->where('bulan', $request->bulan))
        ->orderBy('tahun', 'asc')
        ->orderByRaw("FIELD(bulan, '" . implode("','", $orderBulan) . "')")
        ->orderBy('minggu_ke', 'asc')
        ->get();

    $setting = \App\Models\SiteSetting::first(); // 🛠️ Ambil logo/foto dari setting

    return view('frontend.beranda', compact('bulanan', 'mingguan', 'setting'));
}



    // ================================
    // Helper: Validasi Mingguan
    // ================================
    private function rulesMingguan()
    {
        return [
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
        ];
    }

    // ================================
    // Helper: Validasi Bulanan
    // ================================
    private function rulesBulanan()
    {
        return [
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
        ];
    }
}

        