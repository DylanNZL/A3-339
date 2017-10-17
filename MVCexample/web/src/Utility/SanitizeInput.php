<?php
namespace agilman\a2\Utility;
/**
 * Created by PhpStorm.
 * User: dylancross
 * Date: 17/10/17
 * Time: 1:44 PM
 */

class SanitizeInput
{
    public static function email($email) {
        // Remove whitespace
        $email = trim($email);

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        return $email;
    }

    public static function username($username) {
        // Remove whitespace
        $username = trim($username);

        // Remove html/php tags
        $username = strip_tags($username);

        // escape quotes
        $username = htmlentities($username, ENT_QUOTES, 'UTF-8');

        return $username;
    }

    public static function name($name) {
        // Remove html/php tags
        $name = strip_tags($name);

        // escape quotes
        $name = htmlentities($name, ENT_QUOTES, 'UTF-8');

        return $name;
    }

    public static function password($password) {
        // Use BCrypt in case PHP PASSWORD_DEFAULT changes in the future and we need to match with old passwords?
        $password = password_hash($password, PASSWORD_BCRYPT);
        return $password;
    }
}