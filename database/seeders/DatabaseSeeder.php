<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            InitialUserSeeder::class,
            InitialResortSeeder::class,
            BusinessPatternSeeder::class,
            RentalMenuCategorySeeder::class,
            RentalMenuSeeder::class,
            GearItemCategorySeeder::class,
            GearItemSeeder::class,
            RentalMenuComponentSeeder::class,
        ]);
    }
}
