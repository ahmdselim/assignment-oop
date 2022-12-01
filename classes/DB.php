<?php

namespace App;

require_once("../vendor/autoload.php");

define("DB_HOST", "localhost");
define("DB_USERNAME", "root");
define("DB_PASSWORD", "");
define("DB_NAME", "cart");


class DB implements DB_RUlES
{
    public $con;
    public $table;
    public $query;
    private $where;
    private $like;
    private $data;
    private $update;

    function __construct()
    {
        $this->con = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if (mysqli_connect_error()) {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
            exit();
        }
    }

    public function createDB($table)
    {
        $this->query .= "CREATE DATABASE IF NOT EXISTS `$table` CHARACTER SET utf8";
        return $this;
    }
    public function createTable($table, $rows = [])
    {
        $row = implode(" ,", $rows);
        $sql = "CREATE TABLE IF NOT EXISTS `$table`($row)";
        $q = mysqli_query($this->con, $sql);

        return $q;
    }

    public function table($table)
    {
        $this->table = $table;
        return $this;
    }

    public function select($rows = [])
    {
        foreach ($rows as $row) {
            $rowVal[] = $row;
        }

        $row_implode = implode(",", $rowVal);
        $this->query .= "SELECT $row_implode FROM `$this->table`";
        return $this;
    }

    public function insert($rows = [], $values = [])
    {
        foreach ($values as $value) {
            $valueArr[] =  "'$value'";
        }

        foreach ($rows as $row) {
            $rowVal[] = "`$row`";
        }

        $value_implode = implode(",", $valueArr);
        $row_implode = implode(",", $rowVal);

        $this->query .= "INSERT INTO `$this->table`($row_implode) VALUES($value_implode)";
        return $this;
    }

    public function update(array $data = [])
    {
        $count_data = count($data);
        if ($count_data > 1) {
            foreach ($data as $row => $value) {
                $this->update .= "`$row`='$value'&&";
            }
        } else {
            foreach ($data as $row => $value) {
                $this->update .= "`$row` = '$value'";
            }
        }
        $count_length = strlen($this->update) - 2;
        $trim = substr($this->update, 0, $count_length);

        $this->query .= "UPDATE `$this->table` SET $trim";
        return $this;
    }
    public function delete()
    {
        $this->query .= "DELETE FROM $this->table";
        return $this;
    }
    public function where($rows = [], $condition, $val)
    {
        foreach ($rows as $row) {
            $rowVal[] =  $row;
        }
        $implode_row = implode(" && ", $rowVal);
        $this->query .= " WHERE $implode_row $condition $val";
        return $this;
    }
    public function like($like)
    {
        $this->query .= " LIKE '$like'";
        return $this;
    }
    public function limit($limit)
    {
        $this->query .= " LIMIT $limit";
        return $this;
    }

    public function pagination($page, $per_page)
    {
        $start = $per_page * $page - $per_page;
        $this->query .= " LIMIT $start,$per_page";
        return $this;
    }

    public function execute()
    {
        $q = mysqli_query($this->con, $this->query);
        return $q;
    }
}
$db = new DB();
