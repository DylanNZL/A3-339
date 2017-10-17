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
class ProductModel extends Model implements \JsonSerializable
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
     * @param int $id
     * @return ProductModel $this
     *
     * Load product from database by ID
     */
    public function load($id)
    {
        $query = "SELECT * FROM `product` WHERE `id` = $id;";
        if (!$result = $this->db->query($query)) {
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
            $query = "INSERT INTO `product` VALUES (NULL, '$this->_sku', '$this->_name', '$this->_category',$this->cost, $this->_stock);";
            if (!$result = $this->db->query($query)) {
                // throw new ...
            }
            $this->_id = $this->db->insert_id;
        } else {
            // saving existing product - perform UPDATE on cost/stock
            $query = "UPDATE `product` SET `cost` = $this->cost, `stock` = $this->_stock  WHERE `id` = $this->_id;";
            if (!$result = $this->db->query($query)) {
                // throw new ...
            }
        }
        return $this;
    }

    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    function jsonSerialize()
    {
        return [
                '_id' => $this->_id,
                '_sku' => $this->_sku,
                '_name' => $this->_name,
                '_category' => $this->_category,
                '_cost' => $this->_cost,
                '_stock' => $this->_stock
        ];
    }
}