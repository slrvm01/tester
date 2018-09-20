<?php
/**
 * Created by PhpStorm.
 * User: vladislav
 * Date: 2018-09-17
 * Time: 14:16
 */

require __DIR__ . '/../app/config/config.php';
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../system/base/App.php';

session_start();

new \system\Application();