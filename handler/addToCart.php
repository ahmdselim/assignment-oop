<?php

ob_start();
require_once("../vendor/autoload.php");
session_start();
$ID = $_POST["ID"];
$quantity = $_POST["quantity"];

$db = new App\DB;
$validate = new App\Validate;

$validate->serverRequest("POST")->required("ID", $ID);
$validate->required("quantity", $quantity)->mince("quantity", $quantity);
$validate->checkID("ID", $ID);
$errs = $validate->getErrors();
if (!empty($errs)) {
    $_SESSION["errors"] = $errs;
    header("location:../pages/product.php?id=$ID");
} else {
    $db->createTable("cart", ["id INT NOT NULL PRIMARY KEY AUTO_INCREMENT", "product_id INT NOT NULL", "quantity INT NOT NULL", "FOREIGN KEY (product_id) REFERENCES products(id)"]);

    $db->table("cart")->insert(["product_id", "quantity"], [$ID, $quantity])->execute();
    $_SESSION["success"] = ["product added to cart successfully good luck ya fellah 👨‍🌾"];
    header("location:../pages/product.php?id=$ID");
}

ob_end_flush();
