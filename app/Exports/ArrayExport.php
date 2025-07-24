<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

/**
 * Kelas export dinamis berbasis array.
 * Cocok untuk ekspor custom view seperti IPH Bulanan dan Mingguan.
 */
class ArrayExport implements FromArray, WithHeadings
{
    /**
     * Isi data yang akan diekspor ke Excel.
     * Format: array of array, tiap baris = 1 row Excel
     */
    protected array $data;

    /**
     * Judul kolom Excel di bagian atas.
     * Format: array 1 dimensi.
     */
    protected array $headings;

    /**
     * Konstruktor: isi data & heading yang akan diekspor.
     */
    public function __construct(array $data, array $headings = [])
    {
        $this->data = $data;
        $this->headings = $headings;
    }

    /**
     * Return data utama isi Excel.
     */
    public function array(): array
    {
        return $this->data;
    }

    /**
     * Return heading kolom Excel.
     */
    public function headings(): array
    {
        return $this->headings;
    }
}
