<?php
/**
 * Created by PhpStorm.
 * User: dylancross
 * Date: 13/10/17
 * Time: 3:01 PM
 */

namespace agilman\a2\model;


class ProductCollectionModel extends Model
{
    private $_productIds;
    private $_numbRows;

    public function __construct()
    {
        parent::__construct();

        if (!$result = $this->db->query("SELECT `id` FROM `product`;")) {
            // throw new ...
        }
        $this->_productIds = array_column($result->fetch_all(), 0);
        $this->_numbRows = $result->num_rows;
    }

    /**
     * @param $min
     * @param $max
     *
     * @return array of ProductModel
     */
    public function getProductsBetween($min, $max)
    {
        error_log($min . " "  . $max);
        $products = array();
        foreach ($this->_productIds as $id) {
            if ($id >= $min && $id <= $max) {
                $product = (new ProductModel())->load($id);
                array_push($products, $product);
            }
        }
        return $products;
    }

    public function getAllProducts() {
        $products = array();
        foreach ($this->_productIds as $id) {
            $product = (new ProductModel())->load($id);
            array_push($products, $product);
        }
        return $products;
    }

    public function search($search) {
        if (!$result = $this->db->query("SELECT `id` FROM `product` WHERE UPPER(`name`) LIKE UPPER('%$search%');")) {
            // throw new ...
        }
        $this->_productIds = array_column($result->fetch_all(), 0);
        $this->_numbRows = $result->num_rows;
    }

    public function filter($filter) {
        if (!$result = $this->db->query("SELECT `id` FROM `product` $filter;")) {
            // throw new ...
        }
        $this->_productIds = array_column($result->fetch_all(), 0);
        $this->_numbRows = $result->num_rows;
    }
}