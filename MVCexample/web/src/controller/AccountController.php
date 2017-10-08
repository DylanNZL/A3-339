<?php
namespace agilman\a2\controller;

use agilman\a2\model\AccountModel;
use agilman\a2\model\AccountCollectionModel;
use agilman\a2\view\View;

/**
 * Class AccountController
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class AccountController extends Controller
{
    /**
     * Account Index action (login page GET)
     */
    public function indexAction()
    {
        $view = new View('login');
       echo $view->render();
    }

    /**
     * Account Index action with an error (login page GET)
     * @param String $error
     */
    public function indexActionWithError($error)
    {
        $view = new View('login');
        $view->addData("error", $error);
        echo $view->render();
    }

    /**
     * Account Login action (login page POST)
     * if successful login, render welcome.phtml, else render login page with errors
     */
    public function loginAction()
    {
        ProductController::indexAction();
    }

    /**
     * Account Register action (register page GET)
     */
    public function registerAction()
    {
        $view = new View('register');
        echo $view->render();
    }

    /**
     * Account Register action with an error (register page GET)
     * @param String $error
     */
    public function registerActionWithError($error)
    {
        $view = new View('register');
        $view->addData("error", $error);
        echo $view->render();
    }

    /**
     * Account Register action (register page POST)
     * if successful creation, render welcome.phtml, else render register page with errors
     */
    public function createAction()
    {
       ProductController::indexAction();
    }
}