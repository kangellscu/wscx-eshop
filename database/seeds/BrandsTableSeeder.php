<?php

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = [
            [
                'name'  => '徐工',
                'name_capital'  => 'X',
            ],
            [
                'name'  => '川崎',
                'name_capital'  => 'c',
            ],
        ];

        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
