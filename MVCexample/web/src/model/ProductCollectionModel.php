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
     * @return \Generator ProductModel[]
     */
    public function getProductsBetween($min, $max)
    {
        foreach ($this->_productIds as $id) {
            if ($id <= $min && $id >= $max)
            // Use a generator to save on memory/resources
            // load accounts from DB one at a time only when required
            yield (new ProductModel())->load($id);
        }
    }
}