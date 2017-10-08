<?php
namespace agilman\a2\model;


/**
 * Class AccountModel
 *
 * @package agilman/a2
 */
class AccountModel extends Model
{
    /**
     * @var integer Account ID
     */
    private $_id;
    /**
     * @var string Account Name
     */
    private $_name;

    /**
     * @var String Account UserName
     */
    private $_username;

    /**
     * @var String Account Email
     */
    private $_email;

    /**
     * @var String Account Password
     */
    private $_password;

    /*
     * =========================================================
     * ==================== Getters/Setters ====================
     * =========================================================
     */
    /**
     * @return int Account ID
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * @return string Account Name
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * @param string $_name Account name
     *
     * @return $this AccountModel
     */
    public function setName(string $_name)
    {
        $this->_name = $_name;

        return $this;
    }

    /**
     * @return String
     */
    public function getUsername(): String
    {
        return $this->_username;
    }

    /**
     * @param String $username
     */
    public function setUsername(String $username)
    {
        $this->_username = $username;
    }

    /**
     * @return String
     */
    public function getEmail(): String
    {
        return $this->_email;
    }

    /**
     * @param String $email
     */
    public function setEmail(String $email)
    {
        $this->_email = $email;
    }

    /**
     * @return String
     */
    public function getPassword(): String
    {
        return $this->_password;
    }

    /**
     * @param String $password
     */
    public function setPassword(String $password)
    {
        $this->_password = $password;
    }

    /*
     * =========================================================
     * ======================= Functions =======================
     * =========================================================
     */

    function __construct()
    {
        parent::__construct();
    }

    function __constructWithVar($name, $username, $email, $password) {
        $account = $this->__construct();

        $account->_name = $name;
        $account->_username = $username;
        $account->_email = $email;
        $account->_password = $password;
    }

    /**
     * Loads account information from the database
     *
     * @param int $id Account ID
     *
     * @return $this AccountModel
     */
    public function load($id)
    {
        if (!$result = $this->db->query("SELECT * FROM `account` WHERE `id` = $id;")) {
            // throw new ...
        }

        $result = $result->fetch_assoc();
        $this->_name = $result['name'];
        $this->_username = $result['username'];
        $this->_email = $result['email'];
        $this->_password = $result['password'];
        $this->_id = $id;

        return $this;
    }

    /**
     * @param String $username
     *
     * @return $this
     */
    public function loadFromUsername($username) {
        if (!$result = $this->db->query("SELECT * FROM `account` WHERE `username` = $username;")) {
            // throw new ...
            $this->_id = null;
            $this->_name = null;
            $this->_username = $username;
            $this->_email = null;
            $this->_password = null;

            return $this;
        }

        $result = $result->fetch_assoc();
        $this->_id = $result['id'];
        $this->_name = $result['name'];
        $this->_username = $username;
        $this->_email = $result['email'];
        $this->_password = $result['password'];

        return $this;
    }

    /**
     * Saves account information to the database
     *
     * @return $this AccountModel
     */
    public function save()
    {
        if (!isset($this->_id)) {
            // New account - Perform INSERT
            if (!$result = $this->db->query("INSERT INTO `account` VALUES (NULL,'$this->_name', ' $this->_username', '$this->_email', '$this->_password');")) {
                // throw new ...
            }
            $this->_id = $this->db->insert_id;
        } else {
            // saving existing account - perform UPDATE
            if (!$result = $this->db->query("UPDATE `account` SET `email` = '$this->_email', `password` = '$this->_password' WHERE `id` = $this->_id;")) {
                // throw new ...
            }

        }

        return $this;
    }

}