<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CurrencyValuesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();
        DB::table('currency_values')->insert([
            'id' => 'c182ea3c-4de5-4213-bd59-332dbfabea18',
            'currency_id' => '11540e34-4cd1-448e-af98-a1b14a5abd44',
            'currency_value' => 26.9502,
            'logged_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('currency_values')->insert([
            'id' => '695a081d-a8e1-418d-a02c-d9590cb8a2ea',
            'currency_id' => 'c961cb13-4d6f-44b1-9c41-c1115359daaa',
            'currency_value' => 29.6118,
            'logged_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('currency_values')->insert([
            'id' => '74c737e8-fdc5-4c6d-9d21-2f660c382954',
            'currency_id' => '11540e34-4cd1-448e-af98-a1b14a5abd44',
            'currency_value' => 26.9325,
            'logged_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('currency_values')->insert([
            'id' => 'c90a9426-775f-4015-bad2-d6c22dbec3a3',
            'currency_id' => 'c961cb13-4d6f-44b1-9c41-c1115359daaa',
            'currency_value' => 29.6762,
            'logged_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);
    }
}
