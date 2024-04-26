<?php
require_once (dirname(__FILE__) . "/Utils/Router.php");
require_once ("vendor/autoload.php");

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new Router();
$router->addRoute('/', function () {
    require __DIR__ . '/pages/index.php';
});

$router->addRoute('/product', function () {
    require __DIR__ . '/pages/product.php';
});

$router->addRoute('/allproducts', function () {
    require (__DIR__ . '/pages/allproducts.php');
});


$router->addRoute('/category', function () {
    require __DIR__ . '/Pages/category.php';
});

$router->addRoute('/login', function () {
    require __DIR__ . '/pages/users/login.php';
});

$router->addRoute('/logout', function () {
    require __DIR__ . '/pages/users/logout.php';
});

$router->addRoute('/register', function () {
    require __DIR__ . '/pages/users/register.php';
});

$router->addRoute('/myaccount', function () {
    require __DIR__ . '/pages/users/account.php';
});


$router->dispatch();
?>