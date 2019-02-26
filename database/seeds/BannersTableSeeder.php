<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use App\Models\Banner;

class BannersTableSeeder extends Seeder
{
    const TIME_FORMAT = 'Y-m-d H:i:s';

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banners = [
            [
                'image_url'     => 'https://oimagec3.ydstatic.com/image?id=1298949196441763131&product=xue',
                'begin_time'    => Carbon::createFromFormat(self::TIME_FORMAT, '1990-01-01 00:00:01'),
                'end_time'      => Carbon::createFromFormat(self::TIME_FORMAT, '2999-01-01 00:00:01'),
                'status'        => Banner::STATUS_ACTIVE,
            ],
            [
                'image_url'     => 'https://oimageb5.ydstatic.com/image?id=1344915245099618583&product=xue',
                'begin_time'    => Carbon::createFromFormat(self::TIME_FORMAT, '1990-01-01 00:00:01'),
                'end_time'      => Carbon::createFromFormat(self::TIME_FORMAT, '2999-01-01 00:00:01'),
                'status'        => Banner::STATUS_ACTIVE,
            ],
        ];

        foreach ($banners as $banner) {
            Banner::create($banner);
        }
    }
}
