<?php

namespace App\Exports;

use App\Models\Customer;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        return Customer::select('name', 'email', 'phone')
            ->orderBy('name')
            ->get();
    }

    public function headings(): array
    {
        return ['Name', 'Email', 'Phone'];
    }
}
