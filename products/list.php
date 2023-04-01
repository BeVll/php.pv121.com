<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Головна сторінка</title></head>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/font-awesome.min.css">
<link rel="stylesheet" href="/css/style.css">
<body>
<?php include($_SERVER["DOCUMENT_ROOT"] . "/_header.php"); ?>

<?php include($_SERVER["DOCUMENT_ROOT"] . "/connection.php"); ?>

<main>
    <div class="container">
        <h1 class="text-center">Список товарів</h1>
        <a href="/products/create.php" class="btn btn-success">Додати товар</a>
        <div class="row mt-2 mb-2 ">
            <?php
            $sql = "SELECT * FROM products";
            $command = $dbh->query($sql);
            foreach($command as $row) {
                $name = $row["name"];
                $id = $row["id"];
                $price = $row["price"];
                $description = $row["description"];
                $category_id = $row["category_id"];
                $sql2 = "SELECT * FROM categories WHERE id=$category_id";

                $category = $dbh->query($sql2)->fetch();
                $categoryName = $category["name"];

                $imagesSql = "SELECT * FROM product_images WHERE product_id=$id";
                $images = $dbh->query($imagesSql);
                echo "
                     <div class='col-sm-6 col-md-4 col-lg-3 '>
                        <div class='card' style='width: 100%;'>
                        <a href='/products/addImage.php?id=$id' class='btn btn-primary' style='border-radius: 6px 6px 0 0'>Додати фото</a>
                             <div id='carouselExample$id'  class='carousel slide'>
                                <div class='carousel-inner' style='padding: 40px'>
                                ";
                                if($images) {
                                    $first = true;
                                    foreach ($images as $img) {
                                        $path = $img["path"];
                                        if($first){
                                            echo "
                                             <div class='carousel-item active' style='height: 300px'>
                                                <img class='' style='height: 100%; width: 100%; object-fit: contain'' src='$path'>
                                            </div>
                                            ";
                                            $first = false;
                                        }
                                        else{
                                            echo "
                                             <div class='carousel-item' style='height: 300px'>
                                                <img class='' style='height: 100%; width: 100%; object-fit: contain'' src='$path'>
                                            </div>
                                            ";
                                        }
                                    }
                                }




                                    echo"
                                </div>
                                
                                <button class='carousel-control-prev' type='button' data-bs-target='#carouselExample$id' data-bs-slide='prev'>
                                    <i class='bi bi-chevron-left' style='font-size: 30px; color: black'></i>
                                    <span class='sr-only'>Previous</span>
                                </button>
                                <button class='carousel-control-next' type='button' data-bs-target='#carouselExample$id' data-bs-slide='next'>
                                     <i class='bi bi-chevron-right' style='font-size: 30px; color: black'></i>
                                    <span class='sr-only'>Next</span>
                                </button>
                            </div>
                            <div class='card-body'>
                                <h5 class='card-title'>$name</h5>
                                <p class='card-text' style='height: 100px; overflow: hidden'>$description</p>
                                <div class='d-flex justify-content-between' style='align-items: center'>
                                    <p class='card-text fw-bold fs-2 m-0 p-0'>$price$</p>
                                     <p class='card-text'><small class='text-muted'>$categoryName</small></p>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    ";



            }
            ?>


</main>
<script src="/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js" integrity="sha384-qKXV1j0HvMUeCBQ+QVp7JcfGl760yU08IQ+GpUo5hlbpg51QRiuqHAJz8+BrxE/N" crossorigin="anonymous"></script>
</body>
</html>