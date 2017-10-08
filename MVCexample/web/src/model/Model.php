<?php
namespace agilman\a2\model;

use mysqli;

/**
 * Class Model
 *
 * @package agilman/a2
 * @author  Andrew Gilman <a.gilman@massey.ac.nz>
 */
class Model
{
    protected $db;

    // is this the best place for these constants?
    const DB_HOST = 'mysql';
    const DB_USER = 'root';
    const DB_PASS = 'root';
    const DB_NAME = 'agilman_a2';

    function __construct()
    {
        $this->db = new mysqli(
            Model::DB_HOST,
            Model::DB_USER,
            Model::DB_PASS
            //            Model::DB_NAME
        );

        if (!$this->db) {
            // can't connect to MYSQL???
            // handle it...
            // e.g. throw new someException($this->db->connect_error, $this->db->connect_errno);
        }

        //----------------------------------------------------------------------------
        // This is to make our life easier
        // Create your database and populate it with sample data
        $this->db->query("CREATE DATABASE IF NOT EXISTS ".Model::DB_NAME.";");

        if (!$this->db->select_db(Model::DB_NAME)) {
            // somethings not right.. handle it
            error_log("Mysql database not available!",0);
        }


        /**
         * account table
         */
        $result = $this->db->query("SHOW TABLES LIKE 'account';");
        if ($result->num_rows == 0) {
            // table doesn't exist
            // create it and populate with sample data

            $result = $this->db->query(
                                "CREATE TABLE `account` (
                                          `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
                                          `name` varchar(256) NOT NULL,
                                          `username` varchar(256) NOT NULL,
                                          `email` varchar(256) NOT NULL,
                                          `password` varchar(256) NOT NULL,
                                          PRIMARY KEY (`id`) );"
            );

            if (!$result) {
                // handle appropriately
                error_log("Failed creating table account",0);
            }

            if(!$this->db->query(
                "INSERT INTO `account` VALUES (NULL,'Dylan', 'dylan', 'dylan@example.com', '123'),
                                              (NULL,'Jordan', 'jordan', 'jordan@example.com', '123');"
            )) {
                // handle appropriately
                error_log("Failed creating sample data!",0);
            }
        }

        /**
         * product table
         */
        $result = $this->db->query("SHOW TABLES LIKE 'product';");
        if ($result->num_rows == 0) {
            // table doesn't exist
            // create it and populate with sample data

            $result = $this->db->query(
                "CREATE TABLE `product` (
                                          `id` int(8) unsigned NOT NULL AUTO_INCREMENT,
                                          `sku` varchar(256) NOT NULL,
                                          `name` varchar(256) NOT NULL,
                                          `cost` float(8,2) NOT NULL,
                                          `stock` int(8) NOT NULL,
                                          PRIMARY KEY (`id`) );"
            );

            if (!$result) {
                // handle appropriately
                error_log("Failed creating table account",0);
            }

            if(!$this->db->query(
                "INSERT INTO `product` VALUES (NULL,'ham11', 'Claw Hammer', 39.95, 11),
                                              (NULL,'ham22', 'Sledge Hammer', 66.00, 2),
                                              (NULL,'ham23', 'Soft-Face Hammer', 24.99, 7),
                                              (NULL,'screw03', 'Flat Hammer', 11.95, 25),
                                              (NULL,'ham22', 'Phillips Hammer', 11.95, 30);"

            )) {
                // handle appropriately
                error_log("Failed creating sample data!",0);
            }
        }
        //----------------------------------------------------------------------------
    }
}