<?php

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name'      => '劳保工具',
                'parent_id' => null,
                'display_order' => 0,
                'subs'      => [
                    [
                        'name'  => '防寒服',
                        'display_order' => 10,
                    ],
                    [
                        'name'  => '防辐射眼镜',
                        'display_order' => 20,
                    ],
                ],
            ],
            [
                'name'      => '建筑工具',
                'parent_id' => null,
                'display_order' => 30,
                'subs'      => [
                    [
                        'name'  => '挖掘机',
                        'display_order' => 40,
                    ],
                    [
                        'name'  => '吊车',
                        'display_order' => 50,
                    ],
                ],
            ],
        ];

        foreach ($categories as $category) {
            $subs = array_pull($category, 'subs');
            $currCategory = Category::create($category);
            if ($subs) {
                $parentId = $currCategory->id;
                foreach ($subs as $subCategory) {
                    $subCategory['parent_id'] = $currCategory->id;
                    Category::create($subCategory);
                }
            }
        }
    }
}
