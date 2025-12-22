<?php

namespace App\Exports;

use App\Models\Job;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class JobsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection(): Collection
    {
        return Job::with('customer')
            ->orderBy('title')
            ->get();
    }

    public function map($job): array
    {
        return [
            $job->customer?->name ?? 'N/A',
            $job->title,
            $job->description,
            $job->status,
        ];
    }

    public function headings(): array
    {
        return ['Customer', 'Title', 'Description', 'Status'];
    }
}

