<!DOCTYPE html>
<html lang="en">
<!--divinectorweb.com-->

<head>
    <meta charset="UTF-8">
    <title>Responsive Shopping Cart design</title>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/404.css">
    <link href="../css/cart.css" rel="stylesheet">
</head>

<?php
require_once("../vendor/autoload.php");
session_start();
$validate = new App\Validate;
$db = new App\DB;


$q_cart = $db->table("cart")->select(["*"])->execute();

while ($result = mysqli_fetch_assoc($q_cart)) {
    $data[] = $result;
}

$db->query = "";
$q_products = $db->table("products")->select(["*"])->execute();

while ($result_products = mysqli_fetch_assoc($q_products)) {
    $products[] = $result_products;
};

$allPrices = [];

?>

<body>
    <div class="wrapper">
        <div style="display:flex;justify-content: space-around;"> <a href=" ./insert.php" style="display: flex; justify-content: center; align-items: center; flex-direction: row; margin-top: 50px; color: #9c27b0; font-size: 20px; font-weight: 900;">Add page</a>
            <a href="./cart.php" style="display: flex; justify-content: center; align-items: center; flex-direction: row; margin-top: 50px; color: #9c27b0; font-size: 20px; font-weight: 900;">Cart page</a>
            <a href="./home.php" style="display: flex; justify-content: center; align-items: center; flex-direction: row; margin-top: 50px; color: #9c27b0; font-size: 20px; font-weight: 900;">Home page</a>
        </div>
        <h1>Shopping Cart</h1>
        <div class="project">
            <div class="shop">


                <?php if (isset($_SESSION['errors'])) : foreach ($_SESSION['errors'] as $error) : ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo $error; ?>
                        </div>
                <?php endforeach;
                    unset($_SESSION['errors']);
                endif; ?>
                <?php if (isset($_SESSION['success'])) : foreach ($_SESSION['success'] as $succes) : ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo $succes; ?>
                        </div>
                <?php endforeach;
                    unset($_SESSION['success']);
                endif; ?>


                <?php if (!empty($data)) : foreach ($data as $product) : ?>
                        <?php
                        foreach ($products as $pr) :
                            if ($pr["ID"] === $product["product_id"]) :
                                global $allPrices;

                                $allPrices[] = $pr["price"] * $product["quantity"];
                        ?>
                                <form>
                                    <div class="box" style="height: 100%;">
                                        <img src="../uploads/<?php echo $pr["image"]; ?>" style="height:100%;">
                                        <div class="content">
                                            <h3><?php echo $pr["name"]; ?></h3>
                                            <h3><?php echo $pr["description"]; ?></h3>
                                            <h4>Price: $ <?php echo $pr["price"]; ?></h4>
                                            <p class="unit">Quantity: <?php echo $product["quantity"]; ?></p>
                                            <a href="../handler/delete.php?id=<?php echo $product["id"] ?>">
                                                <p class="btn-area"><i aria-hidden="true" class="fa fa-trash"></i> <span class="btn2">Remove</span></p>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                        <?php endif;
                        endforeach; ?>
                <?php endforeach;
                else : echo "cart is empty";
                endif; ?>
                <!--<button class="btn btn-primary w-100">add</button>-->
            </div>
            <div class="right-bar">
                <p><span>Subtotal</span> <span>$ <?php echo array_sum($allPrices); ?></span></p>
                <hr>
                <p><span>Tax (0%)</span> <span>$0</span></p>
                <hr>
                <p><span>Shipping</span> <span>$0</span></p>
                <hr>
                <p><span>Total</span> <span>$<?php echo array_sum($allPrices); ?></span></p><a href="#"><i class="fa fa-shopping-cart"></i>Cart</a>
            </div>
        </div>
    </div>
</body>

</html>