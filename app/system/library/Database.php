<?php

class Database
{
    private $host = DB_HOSTNAME;
    private $dbUser = DB_USERNAME;
    private $dbPass = DB_PASSWORD;
    private $dbname = DB_DATABASE;

    private $dbHandler;
    /** @var PDOStatement */
    private $dbStatement;
    private $dbErrors;

    public function __construct()
    {
        $dsn = 'mysql:host='.$this->host.';dbname='.$this->dbname;
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_FOUND_ROWS => true,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->dbHandler = new PDO($dsn, $this->dbUser, $this->dbPass, $options);
        } catch (PDOException $e) {
            $this->dbErrors = $e->getMessage();
            dd($this->dbErrors);
        }
    }

    /**
     * @param $sql
     */
    public function query($sql)
    {
        $this->dbStatement = $this->dbHandler->prepare($sql);
    }

    /**
     * @param $param
     * @param $value
     * @param  null  $type
     */
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch ($value) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }

        $this->dbStatement->bindValue($param, $value, $type);
    }

    /**
     * @return bool
     */
    public function execute()
    {
        return $this->dbStatement->execute();
    }

    /**
     * @param  int  $mode
     * @return array
     */
    public function resultSet(int $mode = PDO::FETCH_OBJ)
    {
        $this->execute();
        return $this->dbStatement->fetchAll($mode);
    }


    /**
     * @param  int  $mode
     * @return mixed
     */
    public function single(int $mode = PDO::FETCH_OBJ)
    {
        $this->execute();
        return $this->dbStatement->fetch($mode);
    }

    /**
     * @return int
     */
    public function rowCount()
    {
        return $this->dbStatement->rowCount();
    }

    public function getLastId()
    {
        return $this->dbHandler->lastInsertId();
    }
}
