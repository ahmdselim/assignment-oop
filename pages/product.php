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

$errors = $validate->serverRequest("GET")->queryParameters("id")->getErrors();

if (!empty($errors)) {
    foreach ($errors as $err) {
        echo <<<TEXT
                <div id="notfound"><div class="notfound"><div class="notfound-404"><h1>404</h1></div><h2>$err</h2><p> <a href="./Home.php">Return to homepage</a></p></div></div>
            TEXT;
    }
} else {
    $q = $db->table("products")->select(["*"])->where(["id"], "=", $_GET["id"])->execute();
    while ($result = mysqli_fetch_assoc($q)) {
        $data[] = $result;
    }
?>

    <body>
        <div class="wrapper">
            <div style="display:flex;justify-content: space-around;"> <a href=" ./insert.php" style="display: flex; justify-content: center; align-items: center; flex-direction: row; margin-top: 50px; color: #9c27b0; font-size: 20px; font-weight: 900;">Add page</a>
                <a href="./cart.php" style="display: flex; justify-content: center; align-items: center; flex-direction: row; margin-top: 50px; color: #9c27b0; font-size: 20px; font-weight: 900;">Cart page</a>
                <a href="./home.php" style="display: flex; justify-content: center; align-items: center; flex-direction: row; margin-top: 50px; color: #9c27b0; font-size: 20px; font-weight: 900;">Home page</a>
            </div>
            <?php if (!empty($data)) :  ?>
                <?php foreach ($data as $product) : ?>

                    <h1><?php echo $product["name"]; ?></h1>


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


                    <div class="project">
                        <div class="shop">
                            <form method="POST" action="../handler/addToCart.php">
                                <div class="box" style="height: 100%;">
                                    <img src="../uploads/<?php echo $product["image"]; ?>" style="height:100%;">
                                    <div class="content">
                                        <h3>Name : <?php echo $product["name"]; ?></h3>
                                        <h3>Description : <?php echo $product["description"]; ?></h3>
                                        <h4>Price: $ <?php echo $product["price"]; ?></h4>
                                        <p class="unit">Quantity: <input type="number" name="quantity" value="0"></p>
                                        <input type="hidden" name="ID" value="<?php echo $product["ID"]; ?>">
                                    </div>
                                </div>
                                <button class="btn btn-primary w-100">Add To cart</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else :
                echo <<<TEXT
                <div id="notfound"><div class="notfound"><div class="notfound-404"><h1>404</h1></div><h2>page not found</h2><p> <a href="./Home.php">Return to homepage</a></p></div></div>
            TEXT;
            endif; ?>
        </div>
    </body>

</html>
<?php } ?>