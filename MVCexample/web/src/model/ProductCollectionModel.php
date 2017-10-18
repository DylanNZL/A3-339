<?php

/*Dylan Cross ID#15219491
 *Jordan Felix ID#15152699
 *Assignment 3
 */

namespace a3\model;


class ProductCollectionModel extends Model
{
    private $_productIds;
    private $_numbRows;

    /**
     * ProductCollectionModel constructor.
     */
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
     * @return ProductModel[]
     */
    public function getAllProducts() {
        $products = array();
        foreach ($this->_productIds as $id) {
            $product = (new ProductModel())->load($id);
            array_push($products, $product);
        }
        return $products;
    }

    /**
     * @param string $search
     *
     * Updates the IDs in productIDs with ids for products that's names contain the search term
     */
    public function search($search) {
        $query = "SELECT `id` FROM `product` WHERE UPPER(`name`) LIKE UPPER('%$search%');";
        error_log($query);
        if (!$result = $this->db->query($query)) {
            // throw new ...
        }
        $this->_productIds = array_column($result->fetch_all(), 0);
        $this->_numbRows = $result->num_rows;
    }

    /**
     * @param string $filter
     *
     * Updates the IDs in productIDs with ids for products that's names contain the search term
     */
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