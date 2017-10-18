<?php
namespace a3\Utility;
/**
 * Provides functions to sanitize user input
 */

class SanitizeInput
{
    /**
     * @param string $email
     * @return string mixed|string
     *
     * removes whitespace
     */
    public static function email($email) {
        // Remove whitespace
        $email = trim($email);

        return $email;
    }

    /**
     * @param string $username
     * @return string
     *
     * removes whitespace, html tags and escapes quotes
     */
    public static function username($username) {
        // Remove whitespace
        $username = trim($username);

        // Remove html/php tags
        $username = strip_tags($username);

        // escape quotes
        $username = htmlentities($username, ENT_QUOTES, 'UTF-8');

        return $username;
    }

    /**
     * @param string $name
     * @return string
     *
     * removes html tags and escapes quotes
     */
    public static function name($name) {
        // Remove html/php tags
        $name = strip_tags($name);

        // escape quotes
        $name = htmlentities($name, ENT_QUOTES, 'UTF-8');

        return $name;
    }

    /**
     * @param string $password
     * @return bool|string
     *
     * returns BCrypt encrypted password (60 Characters)
     */
    public static function password($password) {
        // Use BCrypt in case PHP PASSWORD_DEFAULT changes in the future and we need to match with old passwords?
        $password = password_hash($password, PASSWORD_BCRYPT);
        return $password;
    }
}