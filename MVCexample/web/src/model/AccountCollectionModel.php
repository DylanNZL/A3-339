<?php
namespace agilman\a2\model;

/**
 * Class AccountCollectionModel
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class AccountCollectionModel extends Model
{
    private $_accountIds;

    private $_N;

    function __construct()
    {
        parent::__construct();

        $query = "SELECT `id` FROM `account`;";
        if (!$result = $this->db->query($query)) {
            // throw new ...
        }
        $this->_accountIds = array_column($result->fetch_all(), 0);
        $this->_N = $result->num_rows;
    }

    /**
     * Get account collection
     *
     * @return Generator|AccountModel[] Accounts
     */
    public function getAccounts() 
    {
        foreach ($this->_accountIds as $id) {
            // Use a generator to save on memory/resources
            // load accounts from DB one at a time only when required
            yield (new AccountModel())->load($id);
        }
    }


}