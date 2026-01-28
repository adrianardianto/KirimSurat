<?php

namespace App\Exports;

use App\Models\Surat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SuratExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $filters;

    public function __construct($filters)
    {
        $this->filters = $filters;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = Surat::with('category');
        $filters = $this->filters;

        if (isset($filters['search']) && $filters['search']) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('subject', 'like', "%$search%")
                  ->orWhere('reference_number', 'like', "%$search%")
                  ->orWhere('sender', 'like', "%$search%")
                  ->orWhere('recipient', 'like', "%$search%");
            });
        }

        if (isset($filters['type']) && $filters['type']) {
            $query->where('type', $filters['type']);
        }

        if (isset($filters['status']) && $filters['status']) {
            $query->where('status', $filters['status']);
        }

        if (isset($filters['start_date']) && $filters['start_date']) {
            $query->whereDate('date', '>=', $filters['start_date']);
        }

        if (isset($filters['end_date']) && $filters['end_date']) {
            $query->whereDate('date', '<=', $filters['end_date']);
        }

        $sort = $filters['sort'] ?? 'latest';
        if ($sort === 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No. Surat',
            'Tipe',
            'Kategori',
            'Pengirim',
            'Penerima',
            'Subjek',
            'Tanggal',
            'Status',
            'Waktu Dibuat',
        ];
    }

    public function map($surat): array
    {
        return [
            $surat->reference_number,
            ucfirst($surat->type),
            $surat->category ? $surat->category->name : '-',
            $surat->sender,
            $surat->recipient,
            $surat->subject,
            $surat->date,
            ucfirst($surat->status),
            $surat->created_at->format('d-m-Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
