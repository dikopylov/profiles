<?php


namespace Model;


class Database
{
    static protected $connection = null;

    /**
     * @return bool
     */
    static function init ()
    {
        self::$connection = mysqli_connect('localhost', 'root', '');
        if (self::$connection) {
            return mysqli_select_db(self::$connection,'profiles_db');
        }
        return false;
    }

    /**
     * @param $query
     * @return bool|\mysqli_result
     */
    static function query ($query) {
        return mysqli_query(self::$connection, $query);
    }

    /**
     * @param $result \mysqli_result
     * @return array|null
     */
    static function fetch_assoc ($result) {
        return mysqli_fetch_assoc($result);
    }

    /**
     * @param $str string
     * @return string
     */
    static function escape_string ($str) {
        return mysqli_real_escape_string(self::$connection, $str);
    }

    /**
     * @return int|string
     */
    static function insert_id() {
        return mysqli_insert_id(self::$connection);
    }

    /**
     * @return string
     */
    static function error() {
        return mysqli_error(self::$connection);
    }
}