<?php

namespace system\exceptions;

/**
 * Class InvalidRouteException
 * @package system\exceptions
 */
class InvalidRouteException extends \Exception
{
    /**
     * Show 404 error page for not founded pages
     */
    public function showNotFoundPage()
    {
        $this->getMessage();
//        $file = VIEWS . "/404.php";
//        require_once $file;
//        exit();
    }
}