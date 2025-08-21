<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;
use App\Models\Category;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        // Make sure we have categories before companies
        if (Category::count() === 0) {
            $this->call(CategorySeeder::class);
        }

        // Create 30 fake companies
        Company::factory()->count(30)->create();
    }
}
