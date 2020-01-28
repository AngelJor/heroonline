<?php
class ConnectionDb extends PDO
{
    private static $instance = null;

    private static $host = 'localhost';
    private static $user = 'root';
    private static $pass = '';
    private static $name = 'heroonline';

    /* @return PDO
     * */
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            $dsn = 'mysql:host=' . self::$host . ';dbname=' . self::$name;
            //var_dump($dsn);
            self::$instance = new ConnectionDb($dsn, self::$user, self::$pass,
                [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"]);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return self::$instance;
    }
}
