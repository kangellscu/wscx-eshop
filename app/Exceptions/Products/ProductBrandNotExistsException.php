<?php

namespace App\Exceptions\Products;

use App\Exceptions\AppException;
use App\Exceptions\ExceptionCode;

class ProductBrandNotExistsException extends AppException
{
    public function __construct(string $message = '品牌不存在')
    {
        parent::__construct($message, ExceptionCode::PRODUCT_BRAND_NOT_EXISTS);
    }
}
