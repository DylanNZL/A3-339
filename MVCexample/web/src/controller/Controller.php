<?php

/*Dylan Cross ID#15219491
 *Jordan Felix ID#15152699
 *Assignment 3
 */

namespace a3\controller;
namespace a3\controller;

/**
 * Class Controller
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class Controller
{
    /**
     * Generate a link URL for a named route
     *
     * @param string $route  Named route to generate the link URL for
     * @param array  $params Any parameters required for the route
     *
     * @return string  URL for the route
     */
    static function linkTo($route, $params=[])
    {
        // cheating here! What is a better way of doing this?
        $router = $GLOBALS['router'];
        return $router->generate($route, $params);
    }
}