<?php

namespace App;

require_once("../vendor/autoload.php");

class Validate extends DB
{
    private $errors;

    public function required(string $input, mixed $data)
    {
        if (empty($data)) {
            $this->errors[] = ("$input is required");
        }
        return $this;
    }
    public function maxLen(string $input, string $data, int $len)
    {
        if (strlen($data) > $len) {
            $this->errors[] = ("$input must be less than $len");
        }
        return $this;
    }
    public function minLen(string $input, string $data, int $len)
    {
        if (strlen($data) < $len) {
            $this->errors[] = ("$input must be greater than $len");
        }
        return $this;
    }

    public function mince(string $input, mixed $data)
    {
        if ($data < 0) {
            $this->errors[] = "$input must be positive number";
        }
        return $this;
    }
    public function checkEmail($email)
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = "$email email is not valid";
        }
        return $this;
    }

    public function check_repeat_email($email, $table)
    {
        $row = $this->table($table)->select(["*"])->execute();

        while ($result = mysqli_fetch_assoc($row)) {
            $data[] = $result;
        }

        if (!in_array($email, $data)) {
            $this->errors[] = "your email in our database please use another email";
        }
        return $this;
    }

    public function checkID($rowName, $id)
    {
        $row =  $this->table("products")->select(["*"])->where([$rowName], "=", $id)->execute();

        while ($result = mysqli_fetch_assoc($row)) {
            $data[] = $result;
        }

        if (empty($data)) {
            $this->errors[] = "product not found";
        }


        return $this;
    }

    public function serverRequest($action)
    {
        if ($_SERVER["REQUEST_METHOD"] !== strtoupper($action)) {
            $this->errors[] = "404 page";
        }
        return $this;
    }

    public function queryParameters($query)
    {
        $explode_query = explode("=", $_SERVER["QUERY_STRING"]);
        if ($explode_query[0] !== $query) {
            $this->errors[] = "Page not found";
        }
        return $this;
    }

    public function image_upload_errors(int $error)
    {
        if ($error != 0) {
            $this->errors[] = "image not upload please try again";
        }
        return $this;
    }

    public function image_upload_size(int $image_size, int $size)
    {
        $convert_to_megaBytes = intval($size . "00000");
        if ($image_size >= $convert_to_megaBytes) {
            $this->errors[] = "image must be less than $size MegaBytes";
        }
        return $this;
    }

    public function image_upload_extinction(string $image_name, array $extinctions)
    {
        $image_extension = pathinfo($image_name)["extension"];

        if (!in_array($image_extension, $extinctions)) {
            $this->errors[] = "please use another extinction";
        }
        return $this;
    }



    public function getErrors()
    {
        return $this->errors;
    }
}
