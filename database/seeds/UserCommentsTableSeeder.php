<?php

use Illuminate\Database\Seeder;
use App\Models\UserComment;

class UserCommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $comments = [
            [
                'name'          => '章三',
                'phone'         => '13800138000',
                'comment'       => '你好，我想要川崎挖掘机3台',
                'created_at'    => \Carbon\Carbon::yesterday(),
            ],
            [
                'name'  => '方文山',
                'phone' => '13900138000',
                'comment'   => '你好，我想要防寒服20件',
                'created_at'    => \Carbon\Carbon::now(),
            ],
        ];

        foreach ($comments as $comment) {
            UserComment::create($comment);
        }
    }
}
