<?php

use system\Application;
use system\exceptions\UnknownClassException;

/**
 * Class App
 */
class App
{
    /**
     * The application instance
     *
     * @var Application
     */
    public static $app;

    /**
     * This method is invoked automatically when PHP sees an unknown
     * @param string $className
     * @throws UnknownClassException
     */
    public static function autoload($className)
    {
        $classFile = '../' . str_replace('\\', '/', $className) . '.php';
        if (is_file($classFile)) {
            include $classFile;
        } else {
            return;
        }

        if (!class_exists($className, false) && !interface_exists($className, false) && !trait_exists($className, false)) {
            throw new UnknownClassException("Unable to find '$className' in file: '$classFile'. Namespace missing?");
        }
    }
}

spl_autoload_register(['App', 'autoload'], true, true);