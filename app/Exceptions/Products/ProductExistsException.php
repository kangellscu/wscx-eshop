<?php

namespace App\Exceptions\Products;

use App\Exceptions\AppException;
use App\Exceptions\ExceptionCode;

class ProductExistsException extends AppException
{
    public function __construct(string $message = '产品存在')
    {
        parent::__construct($message, ExceptionCode::PRODUCT_EXISTS);
    }
}
