<?php

namespace App\Exports;

use App\Models\Job;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class JobsExport implements FromCollection, WithHeadings
{
    public function collection(): Collection
    {
        return Job::select('title', 'description', 'status')
            ->orderBy('title')
            ->get();
    }

    public function headings(): array
    {
        return ['Title', 'Description', 'Status'];
    }
}
