<?php
session_start();
require_once  "../vendor/autoload.php";

$database = new App\DB;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body>
    <div class="container pt-5">
        <div style="display:flex;justify-content: space-around;"> <a href=" ./insert.php" style="display: flex; justify-content: center; align-items: center; flex-direction: row; margin-top: 50px; color: #9c27b0; font-size: 20px; font-weight: 900;">Add page</a>
            <a href="./cart.php" style="display: flex; justify-content: center; align-items: center; flex-direction: row; margin-top: 50px; color: #9c27b0; font-size: 20px; font-weight: 900;">Cart page</a>
            <a href="./home.php" style="display: flex; justify-content: center; align-items: center; flex-direction: row; margin-top: 50px; color: #9c27b0; font-size: 20px; font-weight: 900;">Home page</a>
        </div>
        <div class="row">
            <div class="col-8 mx-auto">
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
                <form action="../handler/add.php" method="POST" class="border p-4" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">product name</label>
                        <input type="text" name="name" class="form-control">
                        <label class="form-label">product description</label>
                        <input type="text" name="description" class="form-control">
                        <label class="form-label">product image</label>
                        <input type="file" name="image" class="form-control">
                        <label class="form-label">product price</label>
                        <input type="number" name="price" class="form-control">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary">add</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>