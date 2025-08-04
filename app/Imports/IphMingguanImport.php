<?php

namespace App\Imports;

use App\Models\IphMingguan;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class IphMingguanImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            // Lewati header baris pertama (jika ada)
            if ($index === 0) continue;

            $data = [
                'tahun' => $row[1] ?? null,
                'bulan' => $row[2] ?? null,
                'minggu_ke' => $row[3] ?? null,
                'perubahan_harga' => $row[4] ?? null,
                'status_harga' => $this->statusHarga($row[4] ?? 0),
                'fluktuasi_tertinggi' => $row[5] ?? null,
                'disparitas_harga' => $row[16] ?? null,
                'nilai_fluktuasi' => $row[17] ?? null,
            ];

            for ($i = 1; $i <= 5; $i++) {
                $komoditasKey = "nama_komoditas_$i";
                $andilKey = "nilai_andil_$i";
                $data[$komoditasKey] = $row[5 + ($i * 2)] ?? null;
                $data[$andilKey] = $row[6 + ($i * 2)] ?? null;
            }

            $data['waktu'] = now();

            IphMingguan::updateOrCreate([
                'tahun' => $data['tahun'],
                'bulan' => $data['bulan'],
                'minggu_ke' => $data['minggu_ke'],
            ], $data);
        }
    }

    private function statusHarga($value)
    {
        return $value > 0 ? 'Naik' : ($value < 0 ? 'Turun' : 'Stabil');
    }
}
