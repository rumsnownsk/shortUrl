<?php



function getPagination(\JasonGrimes\Paginator $paginator)
{
    include ROOT . '/vendor/jasongrimes/paginator/examples/pager.phtml';

}

function redirect($http = false)
{
    if ($http) {
        $redirect = $http;
    } else {
        $redirect = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '/';
    }

    header("Location: $redirect");
    exit;
}