<?php
ob_start();
require_once("../vendor/autoload.php");
session_start();
$id = $_GET["id"];

$db = new App\DB;
$validate = new App\Validate;
$validate->serverRequest("GET")->checkID("id", $id);

$errs = $validate->getErrors();

if (!empty($errs)) {
    $_SESSION["errors"] = $errs;
    header("location:../pages/cart.php");
} else {
    $db->table = "";
    $db->query = "";
    $db->table("cart")->delete()->where(["id"], "=", $id)->execute();

    $_SESSION["success"] = ["product removed from cart successfully good luck ya fellah 👨‍🌾"];
    header("location:../pages/cart.php");
}

ob_end_flush();
