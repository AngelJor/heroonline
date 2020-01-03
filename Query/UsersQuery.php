<?php


class UsersQuery extends AbstractQuery
{
    private $conn;

    /**
     * usersQuery constructor.
     * @param $conn
     */
    public function __construct()
    {
        $this->conn = ConnectionDb::getInstance();
    }

    public function register($name, $email, $username, $password)
    {
        try {
            $sth = $this->conn->prepare("
                    INSERT INTO 
                        users(name, email, username, password) 
                    VALUES 
                        (:name,:email,:username,:password)
                    ");
            $sth->bindParam("name", $name, PDO::PARAM_STR);
            $sth->bindParam("email", $email, PDO::PARAM_STR);
            $sth->bindParam("username", $username, PDO::PARAM_STR);
            $sth->bindParam("password", $password, PDO::PARAM_STR);
            $sth->execute();
            $_SESSION['myId'] = $this->conn->lastInsertId();
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    public function login($username, $password)
    {
        try {
            $sth = $this->conn->prepare("
                    SELECT 
                        user_id 
                    FROM 
                        users
                    WHERE 
                                (username=:username 
                            OR 
                                email=:username) 
                            AND 
                                password=:password
                    ");
            $sth->bindParam("username", $username, PDO::PARAM_STR);
            $enc_password = hash('sha256', $password);
            $sth->bindParam("password", $enc_password, PDO::PARAM_STR);
            $sth->execute();
            if ($sth->rowCount() > 0) {
                $result = $sth->fetch(PDO::FETCH_OBJ);
                $_SESSION['myId'] = $result->user_id;
                return $result->user_id;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
    function getTableName()
    {
        return 'users';
    }

    function getPrimaryKey()
    {
        return 'user_id';
    }

    public function registerWithFacebook($name,$id)
    {
        try {
            $sth = $this->conn->prepare("
                    INSERT INTO 
                        facebook_users(name, facebook_id) 
                    VALUES 
                        (:name,:facebook_id)
                    ");
            $sth->bindParam("name", $name, PDO::PARAM_STR);
            $sth->bindParam("facebook_id", $id, PDO::PARAM_STR);
            $sth->execute();
            $_SESSION['myId'] = $this->conn->lastInsertId();
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }
}