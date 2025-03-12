<?php

namespace App\Exports;

use App\Models\Member;
use App\Models\Invoice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MembersInvoicesExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * Retrieve all members with their invoices.
     */
    public function collection()
    {
        return Member::with('invoices')->get();
    }

    /**
     * Define column headings for the Excel sheet.
     */
    public function headings(): array
    {
        return [
            'Personnel ID',
            'First Name',
            'Last Name',
            'Department Number',
            'Department Name',
            'Gender',
            'Birthday',
            'Mobile Phone',
            'Card Number',
            'Email',
            'Certificate Type',
            'Certificate Number',
            'Position Number',
            'Position Name',
            'Hire Date',
            'Verification Mode',
            'Office Phone',
            'Employee Type',
            'Office Address',
            'Hire Type',
            'Job Title',
            'Street',
            'Birthplace',
            'Country',
            'Home Phone',
            'Home Address'
        ];
    }

    /**
     * Map data for each member into rows.
     */
    public function map($member): array
    {
        return [
            $member->id,                         // Personnel ID
            $member->name,                       // First Name
            '',                                  // Last Name (empty as not in schema)
            1,                                   // Department Number (defaulted)
            'Department Name',                   // Department Name (defaulted)
            $member->gender,                     // Gender
            '',                                  // Birthday (not in schema)
            $member->phone_number,               // Mobile Phone
            '',                                  // Card Number (empty as not in schema)
            $member->email,                      // Email
            '',                                  // Certificate Type (empty)
            '',                                  // Certificate Number (empty)
            '',                                  // Position Number (empty)
            '',                                  // Position Name (empty)
            '',                                  // Hire Date (not in schema)
            '',                                  // Verification Mode (empty)
            '',                                  // Office Phone (empty)
            '',                                  // Employee Type (empty)
            '',                                  // Office Address (empty)
            '',                                  // Hire Type (empty)
            '',                                  // Job Title (empty)
            '',                                  // Street (empty)
            '',                                  // Birthplace (empty)
            '',                                  // Country (empty)
            '',                                  // Home Phone (empty)
            '',                                  // Home Address (empty)
        ];
    }
}
