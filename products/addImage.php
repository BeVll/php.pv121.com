<?php
$image = "";
$id=$_GET["id"];
include($_SERVER["DOCUMENT_ROOT"] . "/connection.php");
if($_SERVER["REQUEST_METHOD"]=="POST") {

    if (isset($_POST['image']))
        $image = $_POST['image'];


    if (!empty($image)) {
        $sql = "INSERT INTO product_images (path, product_id, IsMain) VALUES (?,?,?)";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([$image, $id, false]);
        header("location: /products/list.php");
        exit();
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Головна сторінка</title></head>
<link rel="stylesheet" href="/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/style.css">
<body>
<?php include($_SERVER["DOCUMENT_ROOT"] . "/_header.php"); ?>


<main>
    <div class="container">
        <h1 class="text-center">Змінить категорію</h1>
        <form method="post" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="image" class="form-label">URL фото</label>
                <input type="text"
                       value="<?php echo $image; ?>"
                       class="form-control"
                       id="image"
                       name="image" required>
                <div class="invalid-feedback">
                    Вкажіть шлях до фото
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Додати</button>
        </form>
    </div>
</main>


<script src="/js/bootstrap.bundle.min.js"></script>
<script src="/js/bootstrap.validation.js"></script>
</body>
</html>