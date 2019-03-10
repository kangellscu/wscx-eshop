<?php

use Illuminate\Database\Seeder;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Sku;

class SkusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $brands = Brand::all();
        $categories = Category::where('parent_id', '<>', null)->get();

        $skus = [
            [
                'name'          => '产品1',
                'brand_id'      => $brands->first()->id,
                'category_id'   => $categories->first()->id,
                'brief_description' => '我的产品1',
                'thumbnail_path'    => 'images/products/p1',
                'status'            => 1,
            ],
            [
                'name'          => '产品2',
                'brand_id'      => $brands->first()->id,
                'category_id'   => $categories->last()->id,
                'brief_description' => '我的产品2',
                'thumbnail_path'    => 'images/products/p2',
                'status'            => 1,
            ],
            [
                'name'          => '产品3',
                'brand_id'      => $brands->last()->id,
                'category_id'   => $categories->first()->id,
                'brief_description' => '我的产品3',
                'thumbnail_path'    => 'images/products/p3',
                'status'            => -1,
            ],
            [
                'name'          => '产品4',
                'brand_id'      => $brands->last()->id,
                'category_id'   => $categories->last()->id,
                'brief_description' => '我的产品4',
                'thumbnail_path'    => 'images/products/p4',
                'status'            => 1,
            ],
        ];

        foreach ($skus as $sku) {
            Sku::create($sku);
        }
    }
}
