<?php
/**
 * Created by PhpStorm.
 * User: dylancross
 * Date: 8/10/17
 * Time: 3:37 PM
 */

namespace agilman\a2\controller;

use agilman\a2\view\View;

/**
 * Class ProductController
 *
 * @package agilman\a2\controller
 */
class ProductController
{
    /**
     * Product Index action (welcome page GET)
     */
    public function indexAction()
    {
        $view = new View('welcome');
        echo $view->render();
    }

    /**
     * Product Browse action (browse page GET)
     */
    public function browseAction()
    {
        $view = new View('browse');
        echo $view->render();
    }

    /**
     * Product Browse action with an error (browse page GET)
     * @param String $error
     */
    public function browseActionWithError($error)
    {
        $view = new View('browse');
        $view->addData("error", $error);
        echo $view->render();
    }

    /**
     * Product Search action (search page GET)
     */
    public function searchAction()
    {
        $view = new View('search');
        echo $view->render();
    }

    /**
     * Product Search action with an error (search page GET)
     * @param String $error
     */
    public function searchActionWithError($error)
    {
        $view = new View('search');
        $view->addData("error", $error);
        echo $view->render();
    }

}