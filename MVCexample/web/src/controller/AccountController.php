<?php
namespace agilman\a2\controller;

use agilman\a2\model\AccountCookie;
use agilman\a2\model\AccountModel;
use agilman\a2\view\View;

/**
 * Class AccountController
 *
 * @package agilman/a2
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
        error_log($_POST['password']);
        error_log($_POST['username']);

        $account = new AccountModel();
        $account = $account->loadFromUsername($_POST['username']);

        if ($account->getId() == null) {
            return($this->indexActionWithError("That username doesn't exist"));
        } else if ($_POST['password'] != $account->getPassword()) {
            return($this->indexActionWithError("Incorrect Password"));
        } else {
            $accountCookie = array('id' => $account->getId(), 'name' => $account->getName(), 'username' => $account->getUsername(), 'email' => $account->getEmail());
            setcookie("account", json_encode($accountCookie), time() + (86400 * 30), "/");
            error_log(json_encode($accountCookie));
            $view = new View('welcome');
            $view->addData("accountName", $accountCookie['name']);
            echo $view->render();
        }
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
        error_log($_POST['name']);
        error_log($_POST['username']);
        error_log($_POST['email']);
        error_log($_POST['password']);
        error_log($_POST['repeat']);

        $account = AccountModel::constructWithVar($_POST['name'], $_POST['username'], $_POST['email'], $_POST['password']);
        $account->save();

        $this->indexAction();
    }
}