<?php

namespace App\Exports;

use App\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\FromQuery;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class UsersExport implements FromView, WithColumnWidths, WithStyles, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection()
    // {
    //     return User::all();
    // }

    // public function startCell(): string
    // {
    //     return 'B2';
    // }

    public function view(): View
    {
        return view('export', [
            'users' => User::all()
        ]);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 35,
            'B' => 35,    
            'C' => 45        
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
          //  'A' => ['font' => ['bold' => true]],
            //'B' => ['font' => ['bold' => true]],

            // Styling an entire column.
          //  'C'  => ['font' => ['size' => 16]],
        ];
    }
}
