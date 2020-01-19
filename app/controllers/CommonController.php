<?php

namespace app\controllers;

use core\Auth;
use DI\DependencyException;
use DI\NotFoundException;
use League\Plates\Engine;

abstract class CommonController
{
    public $view;

    public function __construct()
    {
        global $container;

        try {
            $this->view = $container->get(Engine::class);
        } catch (DependencyException $e) {
            echo 'DependencyException: ' . $e->getMessage();
        } catch (NotFoundException $e) {
            echo 'NotFoundException: ' . $e->getMessage();
        }
    }

    public function render($pathToView, array $data = array())
    {
        echo $this->view->render($pathToView, $data);
    }

    public function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }
}