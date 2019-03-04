<?php

namespace App\Exceptions;


/**
 * Global exception code definitions
 */
final class ExceptionCode
{
    /**
     * Code for general exception
     */
    const GENERAL = 10000;
    const FORM_VALIDATION = 10001;
    const AUTHENTICATION = 10002;
    const AUTHORIZATION = 10003;

    //**********************
    //      Client 
    //**********************
    const CLIENT_NOT_EXISTS = 10101;
    const CLIENT_EXISTS = 10102;
    const CLIENT_NOT_ACTIVATE = 10103;
    const CLIENT_ACTIVED = 10104;
    const CLIENT_MAC_ILLEGAL = 10105;

    //**********************
    //      Admin
    //**********************
    const ADMIN_PASSWORD_INCORRECT = 10201;
    const ADMIN_EXISTS = 10202;

    //**********************
    //      Banner
    //**********************
    const BANNER_ACTIVE_REACH_MAX_THRESHOLD = 10301;

    //**********************
    //      Products
    //**********************
    const PRODUCT_CATEGORY_CANT_DELETE = 10401;
    const PRODUCT_CATEGORY_NOT_EXISTS = 10402;
}
