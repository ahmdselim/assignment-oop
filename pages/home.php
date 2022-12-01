<?php

require_once("../vendor/autoload.php");

$db = new App\DB;
$row = $db->table("products")->select(["*"])->execute();
$rows_num = mysqli_num_rows($row);

$per_page = 5;
$pages = ceil($rows_num / $per_page); // 7/5 = 2

if (isset($_GET["page"])) {
    if ($_GET["page"] > $pages) {
        $page = 1;
    } else {
        $page = $_GET["page"];
    }
} else {
    $page = 1;
}
echo $rows_num;
echo $pages;
$db->query = "";
$paging = $db->table("products")->select(["*"])->pagination($page, $per_page)->execute();

while ($result = mysqli_fetch_assoc($paging)) {
    $data[] = $result;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Responsive E-Commerce product card ui design using HTML CSS</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/products.css">
</head>

<body>
    <div class="wrapper">
        <div style="display:flex;justify-content: space-around;"> <a href=" ./insert.php" style="display: flex; justify-content: center; align-items: center; flex-direction: row; margin-top: 50px; color: #9c27b0; font-size: 20px; font-weight: 900;">Add page</a>
            <a href="./cart.php" style="display: flex; justify-content: center; align-items: center; flex-direction: row; margin-top: 50px; color: #9c27b0; font-size: 20px; font-weight: 900;">Cart page</a>
            <a href="./home.php" style="display: flex; justify-content: center; align-items: center; flex-direction: row; margin-top: 50px; color: #9c27b0; font-size: 20px; font-weight: 900;">Home page</a>
        </div>
        <div class="box">
            <?php foreach ($data as $product) : ?>
                <div class="single-box">
                    <div class="img"><img alt="Round_neck" src="../uploads/<?php echo $product["image"]; ?>"></div>
                    <h3><?php echo $product["name"]; ?></h3>
                    <p><?php echo $product["description"]; ?></p>
                    <div class="price">
                        <p>$ <?php echo $product["price"]; ?></p>
                    </div>
                    <a href="product.php?id=<?php echo $product["ID"]; ?>">Add to Cart</a>
                </div>
            <?php endforeach; ?>
        </div>
        <div style="display: flex;justify-content:space-around;align-items:center;flex-direction:row;width:600px;margin:auto;background:#FFF;padding:10px;position:relative;top:-120px">
            <?php for ($i = 1; $i <= $pages; $i++) : ?>
                <?php if ($i > 10) : ?>
                    <p>pages more than 10</p>
                <?php else :  ?>
                    <a style="margin-left:20px;background:#9c27b0;padding:10px;color:#fff;" href="home.php?page=<?php echo $i; ?>"><?php echo $i; ?></a><?php endif; ?>

            <?php endfor; ?>
        </div>

    </div>
</body>

</html>