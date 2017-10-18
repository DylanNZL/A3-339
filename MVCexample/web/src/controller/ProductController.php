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
        if  (!isset($_COOKIE["account"])) {
            error_log("no cookie");
            AccountController::indexAction();
        } else {
            $view = new View('browse');
            echo $view->render();
        }
    }

    /**
     * Product Search action (search page GET)
     */
    public function searchAction()
    {
        if  (!isset($_COOKIE["account"])) {
            error_log("no cookie");
            AccountController::indexAction();
        } else {
            $view = new View('search');
            echo $view->render();
        }
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
        $productCollectionModel = new ProductCollectionModel();

        // Filters
        if ($_POST['filters'] != null && is_numeric($_POST['filters'])) {
            $filter = $this->getFilters($_POST['filters']);
            if ($filter !== -1) {
                $productCollectionModel->filter($filter);
            }
        }

        $products = $productCollectionModel->getAllProducts();
        echo json_encode($products);
    }

    /**
     * @param  int $filterInt
     * @return int|string
     *
     * Takes the number given by the filter int and returns the corresponding filter
     *
     * Category numbers:
     *      1 = hammers
     *      2 = saws
     *      3 = pliers
     *      4 = screwdrivers
     *
     *      9 = In Stock Only
     *
     * The client side compiles the number and sends it
     */
    private function getFilters($filterInt) {
        error_log("Filter Int = " . $filterInt);
        switch ($filterInt) {
            case 1:
                return "WHERE `category` = 'hammers'";
            case 2:
                return "WHERE `category` = 'saws'";
            case 3:
                return "WHERE `category` = 'pliers'";
            case 4:
                return "WHERE `category` = 'screwdrivers'";
            case 12:
                return "WHERE `category` = 'hammers' OR `category` = 'saws'";
            case 13:
                return "WHERE `category` = 'hammers' OR`category` = 'pliers'";
            case 14:
                return "WHERE `category` = 'hammers' OR`category` = 'screwdrivers'";
            case 23:
                return "WHERE `category` = 'saws' OR`category` = 'pliers'";
            case 24:
                return "WHERE `category` = 'saws' OR`category` = 'screwdrivers'";
            case 34:
                return "WHERE `category` = 'pliers' OR`category` = 'screwdrivers'";
            case 123:
                return "WHERE `category` = 'hammers' OR`category` = 'saws' OR `category` = 'pliers'";
            case 234:
                return "WHERE `category` = 'saws' OR `category` = 'pliers' OR `category` = 'screwdrivers'";
            case 1234:
                return "WHERE `category` = 'hammers' OR`category` = 'saws' OR `category` = 'pliers' OR `category` = 'screwdrivers'";

            case 9:
                return  "WHERE `stock` > 0";
            case 91:
                return "WHERE `category` = 'hammers' AND `stock` > 0";
            case 92:
                return "WHERE `category` = 'saws' AND `stock` > 0";
            case 93:
                return "WHERE `category` = 'pliers' AND `stock` > 0";
            case 94:
                return "WHERE `category` = 'screwdrivers' AND `stock` > 0";
            case 912:
                return "WHERE `category` = 'hammers' AND `stock` > 0 OR `category` = 'saws' AND `stock` > 0";
            case 913:
                return "WHERE `category` = 'hammers' AND `stock` > 0 OR`category` = 'pliers' AND `stock` > 0";
            case 914:
                return "WHERE `category` = 'hammers' AND `stock` > 0 OR`category` = 'screwdrivers' AND `stock` > 0";
            case 923:
                return "WHERE `category` = 'saws' AND `stock` > 0 OR`category` = 'pliers' AND `stock` > 0";
            case 924:
                return "WHERE `category` = 'saws' AND `stock` > 0 OR`category` = 'screwdrivers' AND `stock` > 0";
            case 934:
                return "WHERE `category` = 'pliers' AND `stock` > 0 OR`category` = 'screwdrivers' AND `stock` > 0";
            case 9123:
                return "WHERE `category` = 'hammers' AND `stock` > 0 OR`category` = 'saws' AND `stock` > 0 OR `category` = 'pliers' AND `stock` > 0";
            case 9234:
                return "WHERE `category` = 'saws' AND `stock` > 0 OR `category` = 'pliers' AND `stock` > 0 OR `category` = 'screwdrivers' AND `stock` > 0";
            case 91234:
                return "WHERE `category` = 'hammers' AND `stock` > 0 OR`category` = 'saws' AND `stock` > 0 OR `category` = 'pliers' AND `stock` > 0 OR `category` = 'screwdrivers' AND `stock` > 0";

            default:
                return -1;
        }

    }

    public function searchProductsAction() {
        error_log('sp post: ' . $_POST['search']);

        if ($_POST['search'] == null || $_POST['search'] == "") {
            return;
        }

        $productCollectionModel = new ProductCollectionModel();
        $productCollectionModel->search($_POST['search']);
        $products = $productCollectionModel->getAllProducts();

        echo json_encode($products);
    }

}