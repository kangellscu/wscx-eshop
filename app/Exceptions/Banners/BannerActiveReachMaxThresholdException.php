<?php

namespace App\Exceptions\Banners;

use App\Exceptions\AppException;
use App\Exceptions\ExceptionCode;

class BannerActiveReachMaxThresholdException extends AppException
{
    public function __construct(string $message = '激活Banner数已经达到上限')
    {
        parent::__construct($message, ExceptionCode::BANNER_ACTIVE_REACH_MAX_THRESHOLD);
    }
}
