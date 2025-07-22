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
        $status = 'Stabil';
        if ($request->perubahan_harga > 0) {
            $status = 'Naik';
        } elseif ($request->perubahan_harga < 0) {
            $status = 'Turun';
        }

        $data = $request->all();
        $data['status_harga'] = $status;

        IphMingguan::create($data);

        return redirect()->back()->with('success', 'Data IPH Mingguan berhasil disimpan.');
    }

    public function saveBulanan(Request $request)
    {
        $status = 'Stabil';
        if ($request->perubahan_harga > 0) {
            $status = 'Naik';
        } elseif ($request->perubahan_harga < 0) {
            $status = 'Turun';
        }

        $data = $request->all();
        $data['status_harga'] = $status;

        IphBulanan::create($data);

        return redirect()->back()->with('success', 'Data IPH Bulanan berhasil disimpan.');
    }

    // Tampilkan Data
    public function viewMingguan(Request $request)
    {
        $query = IphMingguan::query();

        if ($request->tahun) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->bulan) {
            $query->where('bulan', $request->bulan);
        }

        $data = $query->orderByDesc('created_at')->get();

        return view('admin.view_mingguan', compact('data'));
    }

    public function viewBulanan(Request $request)
    {
        $query = IphBulanan::query();

        if ($request->tahun) {
            $query->where('tahun', $request->tahun);
        }

        if ($request->bulan) {
            $query->where('bulan', $request->bulan);
        }

        $data = $query->orderByDesc('created_at')->get();

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
        $status = 'Stabil';
        if ($request->perubahan_harga > 0) {
            $status = 'Naik';
        } elseif ($request->perubahan_harga < 0) {
            $status = 'Turun';
        }

        $data = $request->except('_token');
        $data['status_harga'] = $status;

        IphMingguan::where('id', $id)->update($data);

        return redirect('/admin/iph/view-mingguan')->with('success', 'Data IPH Mingguan berhasil diperbarui.');
    }

    public function updateBulanan(Request $request, $id)
    {
        $status = 'Stabil';
        if ($request->perubahan_harga > 0) {
            $status = 'Naik';
        } elseif ($request->perubahan_harga < 0) {
            $status = 'Turun';
        }

        $data = $request->except('_token');
        $data['status_harga'] = $status;

        IphBulanan::where('id', $id)->update($data);

        return redirect('/admin/iph/view-bulanan')->with('success', 'Data IPH Bulanan berhasil diperbarui.');
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
}
