<?php
ob_start();
require_once("../vendor/autoload.php");

session_start();
$validate = new App\Validate;
$db = new App\DB;

$name = $_POST["name"];
$description = $_POST["description"];
$image = $_FILES["image"];
$image_name = $_FILES["image"]["name"];
$image_tmp_name = $_FILES["image"]["tmp_name"];
$image_error = $_FILES["image"]["error"];
$image_size = $_FILES["image"]["size"];
$price = $_POST["price"];
$extensions = ["png", "jpg", "jpeg"];
$path = "../uploads/";
if (!empty($image)) {
}


$validate->serverRequest("post")->required("product name", $name)->maxLen("product name", $name, 20)->minLen("product name", $name, 2);

$validate->serverRequest("post")->required("product description", $description)->maxLen("product description", $description, 400)->minLen("product description", $description, 6);

$validate->serverRequest("post")->required("product image", $image)->image_upload_errors($image_error)->image_upload_size($image_size, 5)->image_upload_extinction($image_name, $extensions);

$validate->serverRequest("post")->required("product price", $price)->mince("product price", $price);

if ($validate->getErrors() > 0) {
    $_SESSION["errors"] = $validate->getErrors();
    header("location:../pages/insert.php");
} else {
    unset($_SESSION["errors"]);
    $image_extension = pathinfo($image_name)["extension"];
    $newName = uniqid("", true) . "." . $image_extension;
    $distension =  $path . $newName;

    $db->createTable("products", ["ID INT PRIMARY KEY AUTO_INCREMENT", "name VARCHAR(255) NOT NULL", "image VARCHAR(255) NOT NULL", "price INT NOT NULL"]);

    $db->table("products")->insert(["name", "description", "image", "price"], [$name, $description, $newName, $price])->execute();

    move_uploaded_file($image_tmp_name, $distension);

    $_SESSION["success"] = ["congrats product upload successfully ☑"];
    header("location:../pages/insert.php");
}

ob_end_flush();
