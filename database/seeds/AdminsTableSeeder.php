<?php

use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admins = [
            [
                'name'      => 'admin',
                'password'  => bcrypt('admin'),
            ],
            [
                'name'      => 'wenqi',
                'password'  => bcrypt('wenqi'),
            ],
        ];

        foreach ($admins as $admin) {
            Admin::create($admin);
        }
    }
}
