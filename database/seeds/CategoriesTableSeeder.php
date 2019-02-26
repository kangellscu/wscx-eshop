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
                'level'     => Category::LEVEL_TOP,
                'subs'      => [
                    [
                        'name'  => '防寒服',
                        'level' => 10,
                    ],
                    [
                        'name'  => '防辐射眼镜',
                        'level' => 10,
                    ],
                ],
            ],
            [
                'name'      => '建筑工具',
                'parent_id' => null,
                'level'     => Category::LEVEL_TOP,
                'subs'      => [
                    [
                        'name'  => '挖掘机',
                        'level' => 10,
                    ],
                    [
                        'name'  => '吊车',
                        'level' => 10,
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
