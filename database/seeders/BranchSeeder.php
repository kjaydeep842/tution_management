<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    public function run(): void
    {
        $branches = [
            ['name' => 'Nikol', 'address' => 'Nikol, Ahmedabad', 'phone' => '', 'is_active' => true],
            ['name' => 'Naroda', 'address' => 'Naroda, Ahmedabad', 'phone' => '', 'is_active' => true],
        ];

        foreach ($branches as $branch) {
            Branch::firstOrCreate(['name' => $branch['name']], $branch);
        }
    }
}
