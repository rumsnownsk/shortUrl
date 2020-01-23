<?php

use Illuminate\Database\Capsule\Manager;

// Соедитение с Базой Данных
$m = new Manager;
$m->addConnection([
    'driver' => 'mysql',
    'host' => 'localhost',
    'database' => 'short-url',
    'username' => '',
    'password' => '',
    'charset' => 'utf8',
    'collation' => 'utf8_general_ci',
    'prefix' => ''
]);
// Make this Capsule instance available globally via static methods... (optional)
$m->setAsGlobal();
// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$m->bootEloquent();
//dd($capsule);

