<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CustomersExport implements FromCollection, WithHeadings, WithMapping
{
    // public function collection(): \Illuminate\Support\Collection
    // {
    //     return Customer::withCount('jobs')
    //         ->orderBy('name')
    //         ->get();
    // }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Phone',
            // 'Jobs Count',
            // 'Created At',
        ];
    }

    public function map($customer): array
    {
        return [
            $customer->id,
            $customer->name,
            $customer->email,
            $customer->phone,
            // $customer->jobs_count,
            // $customer->created_at?->format('d-m-Y'),
        ];
    }
}
