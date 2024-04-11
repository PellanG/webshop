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

// $router->addRoute('/input', function () {
//     require __DIR__ . '/Pages/form.php';
// });

// $router->addRoute('/viewcustomer', function () {
//     require __DIR__ . '/Pages/viewcustomer.php';
// });

// $router->addRoute('/admin', function () {
//     require __DIR__ . '/Pages/admin.php';
// });

// $router->addRoute('/user/login', function () {
//     require __DIR__ . '/Pages/users/login.php';
// });

// $router->addRoute('/user/logout', function () {
//     require __DIR__ . '/Pages/users/logout.php';
// });

// $router->addRoute('/user/register', function () {
//     require __DIR__ . '/Pages/users/register.php';
// });



$router->dispatch();
?>