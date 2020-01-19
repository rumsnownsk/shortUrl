<?php

define("ROOT", dirname(__DIR__));
define("APP", dirname(__DIR__).'/app');
define("VIEWS", dirname(__DIR__).'/app/views');
define("DEBUG",true);

require ROOT.'/core/ErrorHandler.php';
require ROOT.'/vendor/autoload.php';
require ROOT.'/core/db.php';
require ROOT.'/core/helpers.php';
require ROOT.'/core/router.php';