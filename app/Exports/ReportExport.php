<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;

class ReportExport implements FromArray
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        return [
            ['Month', 'Members', 'Invoices'],
            ...array_map(function ($month) {
                return [
                    'Month' => $month,
                    'Members' => $this->data['members'][$month - 1]['total'] ?? 0,
                    'Invoices' => $this->data['invoices'][$month - 1]['total'] ?? 0,
                ];
            }, range(1, 12)),
        ];
    }
}
