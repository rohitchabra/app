<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TradeSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $trades = [
            'Carpentry',
            'Roofing',
            'Plumber',
            'Solar',
            'Window',
            // 'Sliding',
            // 'Door',
            // 'Gardening',
            // 'Electrical',
        ];

        $rows = array_map(function ($name) use ($now) {
            return [
                'name'       => $name,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }, $trades);

        //DB::table('trades')->insert($rows);

        //$trades = ['Carpentry','Roofing','Plumber','Solar','Window','Sliding','Door','AAA'];

        foreach ($trades as $trade) {
            \App\Models\Trade::firstOrCreate(['name' => $trade, 'trade_id' => 'system']);
        }

    }
}
