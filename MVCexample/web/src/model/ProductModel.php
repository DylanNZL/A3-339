<?php
/**
 * Created by PhpStorm.
 * User: dylancross
 * Date: 8/10/17
 * Time: 3:59 PM
 */

namespace agilman\a2\model;

/**
 * Class ProductModel
 * @package agilman\a2\model
 */
class ProductModel extends Model
{
    /**
     * @var integer Product ID
     */
    private $_id;

    /**
     * @var String Product SKU
     */
    private $_sku;

    /**
     * @var String Product Name
     */
    private $_name;

    /**
     * @var String Product Category
     */
    private $_category;

    /**
     * @var Float Product Cost
     */
    private $_cost;

    /**
     * @var integer Product Stock
     */
    private $_stock;

    /*
     * =========================================================
     * ==================== Getters/Setters ====================
     * =========================================================
     */

    /**
     * @return int
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->_id = $id;
    }

    /**
     * @return String
     */
    public function getSKU()
    {
        return $this->_sku;
    }

    /**
     * @param String $sku
     */
    public function setSKU($sku)
    {
        $this->_sku = $sku;
    }

    /**
     * @return String
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param String $name
     */
    public function setName($name)
    {
        $this->_name = $name;
    }

    /**
     * @return Float
     */
    public function getCost()
    {
        return $this->_cost;
    }

    /**
     * @param Float $cost
     */
    public function setCost($cost)
    {
        $this->_cost = $cost;
    }

    /**
     * @return int
     */
    public function getStock()
    {
        return $this->_stock;
    }

    /**
     * @param int $stock
     */
    public function setStock($stock)
    {
        $this->_stock = $stock;
    }

    /**
     * @return String
     */
    public function getCategory(): String
    {
        return $this->_category;
    }

    /**
     * @param String $category
     */
    public function setCategory(String $category)
    {
        $this->_category = $category;
    }

    /*
     * =========================================================
     * ======================= Functions =======================
     * =========================================================
     */

    /**
     * ProductModel constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param $sku
     * @param $name
     * @param $category
     * @param $cost
     * @param $stock
     *
     * @return ProductModel
     */
    public function __constructWithVar($sku, $name, $category, $cost, $stock) {
        $product = $this->__construct();

        $product->_sku = $sku;
        $product->_name = $name;
        $product->_category = $category;
        $product->_cost = $cost;
        $product->_stock = $stock;

        return $product;
    }

    /**
     * @param String $id
     * @return ProductModel $this
     *
     * Load product from database by ID
     */
    public function load($id)
    {
        if (!$result = $this->db->query("SELECT * FROM `product` WHERE `id` = $id;")) {
            // throw new ...
        }

        $result = $result->fetch_assoc();

        $this->_id = $result['id'];
        $this->_sku = $result['sku'];
        $this->_name = $result['name'];
        $this->_category = $result['category'];
        $this->_cost = $result['cost'];
        $this->_stock = $result['stock'];

        return $this;
    }

    /**
     * Saves product information to the database, or updates it if it exists already
     * @return $this ProductModel
     */
    public function save()
    {
        if (!isset($this->_id)) {
            // New product - Perform INSERT
            if (!$result = $this->db->query("INSERT INTO `product` VALUES (NULL, '$this->_sku', '$this->_name', '$this->_category',$this->cost, $this->_stock);")) {
                // throw new ...
            }
            $this->_id = $this->db->insert_id;
        } else {
            // saving existing product - perform UPDATE on cost/stock
            if (!$result = $this->db->query("UPDATE `product` SET `cost` = $this->cost, `stock` = $this->_stock  WHERE `id` = $this->_id;")) {
                // throw new ...
            }
        }
        return $this;
    }

}