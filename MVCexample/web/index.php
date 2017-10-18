<?php

/*Dylan Cross ID#15219491
 *Jordan Felix ID#15152699
 *Assignment 3
 */

date_default_timezone_set('Pacific/Auckland');

require __DIR__ . '/vendor/autoload.php';

use PHPRouter\RouteCollection;
use PHPRouter\Router;
use PHPRouter\Route;

define('APP_ROOT', __DIR__);

$collection = new RouteCollection();

// Home GET - Project index
$collection->attachRoute(
    new Route(
        '/', array(
            '_controller' => 'agilman\a2\controller\AccountController::indexAction',
            'methods' => 'GET',
            'name' => 'accountIndex'
        )
    )
);

// Login POST
$collection->attachRoute(
    new Route(
        '/login', array(
            '_controller' => 'agilman\a2\controller\AccountController::loginAction',
            'methods' => 'POST',
            'name' => 'accountLogin'
        )
    )
);

// Register GET
$collection->attachRoute(
    new Route(
        '/register', array(
            '_controller' => 'agilman\a2\controller\AccountController::registerAction',
            'methods' => 'GET',
            'name' => 'accountRegister'
        )
    )
);

// Register POST
$collection->attachRoute(
    new Route(
        '/register', array(
            '_controller' => 'agilman\a2\controller\AccountController::createAction',
            'methods' => 'POST',
            'name' => 'accountCreate'
        )
    )
);

// Home GET
$collection->attachRoute(
    new Route(
        '/home', array(
            '_controller' => 'agilman\a2\controller\ProductController::indexAction',
            'methods' => 'GET',
            'name' => 'productIndex'
        )
    )
);

// Browse GET
$collection->attachRoute(
    new Route(
        '/browse', array(
            '_controller' => 'agilman\a2\controller\ProductController::browseAction',
            'methods' => 'GET',
            'name' => 'accountBrowse'
        )
    )
);

// Search GET
$collection->attachRoute(
    new Route(
        '/search', array(
            '_controller' => 'agilman\a2\controller\ProductController::searchAction',
            'methods' => 'GET',
            'name' => 'accountBrowse'
        )
    )
);

// Logout GET
$collection->attachRoute(
    new Route(
        '/logout', array(
            '_controller' => 'agilman\a2\controller\AccountController::logoutAction',
            'methods' => 'GET',
            'name' => 'accountLogin'
        )
    )
);

// Check Username POST
$collection->attachRoute(
    new Route(
        '/checkUserName', array(
            '_controller' => 'agilman\a2\controller\AccountController::usernameAction',
            'methods' => 'POST',
            'name' => 'accountCheckUserName'
        )
    )
);

// Get Products POST
$collection->attachRoute(
    new Route(
        '/products', array(
            '_controller' => 'agilman\a2\controller\ProductController::productAction',
            'methods' => 'POST',
            'name' => 'productGetProducts'
        )
    )
);

// Search Products POST
$collection->attachRoute(
    new Route(
        '/search', array(
            '_controller' => 'agilman\a2\controller\ProductController::searchProductsAction',
            'methods' => 'POST',
            'name' => 'productSearchProducts'
        )
    )
);

$router = new Router($collection);
$router->setBasePath('/');

$route = $router->matchCurrentRequest();

// If route was dispatched successfully - return
if ($route) {
    // true indicates to webserver that the route was successfully served
    return true;
}

// Otherwise check if the request is for a static resource
$info = parse_url($_SERVER['REQUEST_URI']);
// check if its allowed static resource type and that the file exists
if (preg_match('/\.(?:png|jpg|jpeg|css|js)$/', "$info[path]")
    && file_exists("./$info[path]")
) {
    // false indicates to web server that the route is for a static file - fetch it and return to client
    return false;
} else {
    header("HTTP/1.0 404 Not Found");
    // Custom error page
    // require 'static/html/404.html';
    return true;
}