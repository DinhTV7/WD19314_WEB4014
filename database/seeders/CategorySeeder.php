<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('categories')->insert([
        //     [
        //         'ten_danh_muc' => 'Áo khoác',
        //         'trang_thai' => true,
        //         'created_at' => now()
        //     ],
        //     [
        //         'ten_danh_muc' => 'Áo thun',
        //         'trang_thai' => true,
        //         'created_at' => now()
        //     ]
        // ]);

        Category::factory()->count(5)->create();
    }
}
