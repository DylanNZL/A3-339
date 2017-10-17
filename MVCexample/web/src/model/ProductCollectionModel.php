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

        $query = "SELECT `id` FROM `product`;";
        if (!$result = $this->db->query($query)) {
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
        $i = 0;
        foreach ($this->_productIds as $id) {
            if ($i >= $min && $i <= $max) {
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
        $query = "SELECT `id` FROM `product` WHERE UPPER(`name`) LIKE UPPER('%$search%');";
        error_log($query);
        if (!$result = $this->db->query($query)) {
            // throw new ...
        }
        $this->_productIds = array_column($result->fetch_all(), 0);
        $this->_numbRows = $result->num_rows;
    }

    public function filter($filter) {
        $query = "SELECT `id` FROM `product` $filter;";
        error_log($query);
        if (!$result = $this->db->query($query)) {
            // throw new ...
        }
        $this->_productIds = array_column($result->fetch_all(), 0);
        $this->_numbRows = $result->num_rows;
    }
}