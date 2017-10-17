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
                "INSERT INTO `account` VALUES (NULL,'Dylan', 'dylan', 'dylan@example.com', '". password_hash("123", PASSWORD_BCRYPT) . "'),
                                              (NULL,'Jordan', 'jordan', 'jordan@example.com', '". password_hash("123", PASSWORD_BCRYPT) ."'),
                                              (NULL, 'Tim Taylor', 'TheToolman', 'tim@thetoolman.com', '" . password_hash("TheToolman", PASSWORD_BCRYPT) ."');"
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
                                          `category` varchar(258) NOT NULL,
                                          `stock` int(8) NOT NULL,
                                          PRIMARY KEY (`id`) );"
            );

            if (!$result) {
                // handle appropriately
                error_log("Failed creating table account",0);
            }

            if(!$this->db->query(
                "INSERT INTO `product` VALUES (NULL,'ham11', 'Claw Hammer', 39.95, 'hammers', 11),
                                              (NULL,'ham22', 'Sledge Hammer', 66.00, 'hammers', 2),
                                              (NULL,'ham23', 'Soft-Face Hammer', 24.99, 'hammers', 7),
                                              (NULL,'ham23', 'Full Size Wrecking Bar', 45.99, 'hammers', 2),
                                              (NULL,'ham23', 'mini Wrecking Bar', 24.99, 'hammers', 2),
                                              (NULL,'screw01', 'Flat Head Screwdriver', 11.95, 'screwdrivers', 17),
                                              (NULL,'screw02', 'Phillips Head Screwdrivers', 11.95, 'screwdrivers', 13),
                                              (NULL,'screw03', 'Square Head Screwdrivers', 11.95, 'screwdrivers', 11),
                                              (NULL,'screw04', 'Torx Head Screwdrivers', 11.95, 'screwdrivers', 15),
                                              (NULL,'screw11', 'Flat Head Screwdriver VDE', 29.99, 'screwdrivers', 2),
                                              (NULL,'screw12', 'Phillips Head Screwdrivers VDE', 29.99, 'screwdrivers', 3),
                                              (NULL,'screw13', 'Square Head Screwdrivers VDE', 29.99, 'screwdrivers', 1),
                                              (NULL,'screw14', 'Torx Head Screwdrivers VDE', 29.99, 'screwdrivers', 2),
                                              (NULL,'screw14', 'Torx Head Screwdrivers VDE', 29.99, 'screwdrivers', 0),
                                              (NULL,'screw00', '4 Pce Screwdriver Set', 69.00, 'screwdrivers', 2),
                                              (NULL,'screw30', '9 Pce Hex Allen Key Set', 32.00, 'screwdrivers', 3),
                                              (NULL,'plier01', 'Linesman Pliers', 5.95, 'pliers', 3),
                                              (NULL,'plier02', 'Long Nose Pliers', 5.95, 'pliers', 3),
                                              (NULL,'plier03', 'Diagonal Pliers', 5.95, 'pliers', 3),
                                              (NULL,'plier04', 'Groove Joint Pliers', 5.95, 'pliers', 3),
                                              (NULL,'plier05', 'End Nipper Pliers', 5.95, 'pliers', 3),
                                              (NULL,'saw01', 'Hardpoint Saw', 40.00, 'saws', 17),
                                              (NULL,'saw02', 'Insulation Saw', 20.00, 'saws', 2),
                                              (NULL,'saw03', 'Dovetail Saw', 35.00, 'saws', 10),
                                              (NULL,'saw04', 'Pull Saw', 30.00, 'saws', 7),
                                              (NULL,'saw05', 'Toolbox Saw', 30.00, 'saws', 7);"


            )) {
                // handle appropriately
                error_log("Failed creating sample data!",0);
            }
        }
        //----------------------------------------------------------------------------
    }
}