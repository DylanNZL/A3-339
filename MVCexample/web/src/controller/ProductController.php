<?php
/**
 * Created by PhpStorm.
 * User: dylancross
 * Date: 8/10/17
 * Time: 3:37 PM
 */

namespace agilman\a2\controller;

use agilman\a2\model\ProductCollectionModel;
use agilman\a2\model\ProductModel;
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
        if  (!isset($_COOKIE["account"])) {
            error_log("no cookie");
            AccountController::indexAction();
        } else {
            $accountCookie = json_decode($_COOKIE["account"], true);

            $view = new View('welcome');
            $view->addData("accountName", $accountCookie['name']);
            echo $view->render();
        }
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

    /**
     *
     */
    public function productAction() {
//        error_log($_POST['current']);
        if ($_POST['current'] == null || is_numeric($_POST['current'])) {
            $current = 0;
        } else {
            $current = $_POST['current'];
        }

        $productCollectionModel = new ProductCollectionModel();
        error_log($_POST['inStockOnly']);

        // In Stock
        if ($_POST['inStockOnly'] != null) {
            //TODO:
        }

        // Category filters
        // TODO:
        if ($_POST ['hammers'] != null) {

        }
        if ($_POST['heatGuns'] != null) {

        }
        if ($_POST['pliers'] != null) {

        }
        if ($_POST['screwdrivers'] != null) {

        }

        $products = $productCollectionModel->getProductsBetween($current, $current + 20);

        echo json_encode($products);
    }

    public function searchProductsAction() {
        error_log('sp post: ' . $_POST['search']);

        if ($_POST['search'] == null || $_POST['search'] == "") {
            return;
        }

        $productCollectionModel = new ProductCollectionModel();
        $productCollectionModel->search($_POST['search']);
        $products = $productCollectionModel->getProductsBetween(0,20);

        echo json_encode($products);
    }

}