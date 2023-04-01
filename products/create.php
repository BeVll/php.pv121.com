<?php
$name = "";
$price = 0;
$description = "";
$category_id = "";
$categories = null;
include($_SERVER["DOCUMENT_ROOT"] . "/connection.php");
$sql2 = "SELECT * FROM categories";
$categories = $dbh->query($sql2);
if($_SERVER["REQUEST_METHOD"]=="POST") {



    if (isset($_POST['name']))
        $name = $_POST['name'];
    if (isset($_POST['price']))
        $price = $_POST['price'];
    if (isset($_POST['description']))
        $description = $_POST['description'];
    if (isset($_POST['category_id']))
        $category_id = $_POST['category_id'];
    echo "$name, $price, $description, $category_id";

        echo "Add";
        $sql = "INSERT INTO products (name, price, description, category_id) VALUES (?,?,?,?)";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([$name, $price, $description, $category_id]);
        header("location: /");
        exit();

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
        <h1 class="text-center">Додати товар</h1>

        <form method="post" class="needs-validation" novalidate>
            <div class="mb-3">
                <label for="name" class="form-label">Назва</label>
                <input type="text"
                       class="form-control"
                       value="<?php echo $name; ?>"
                       id="name"
                       name="name" required>
                <div class="invalid-feedback">
                    Вкажіть назву категорії
                </div>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Ціна</label>
                <input type="number"
                       value="<?php echo $price; ?>"
                       class="form-control"
                       id="price"
                       name="price" required>
                <div class="invalid-feedback">
                    Вкажіть ціну
                </div>
            </div>

            <div class="mb-3">
                <div class="form-floating">
                    <textarea class="form-control"
                              name="description"
                              placeholder="Leave a comment here"
                              id="description"
                              style="height: 100px" required><?php echo $description; ?></textarea>
                    <div class="invalid-feedback">
                        Вкажіть опис категорії
                    </div>
                    <label for="description">Опис</label>
                </div>

            </div>
            <div class="mb-3">
                    <select class="form-select" name="category_id" id="catedory_id" aria-label="Default select example">
                        <?php
                            foreach ($categories as $cat){
                                $catId = $cat["id"];
                                $catName = $cat["name"];
                                echo "
                                    <option value='$catId'>$catId - $catName</option>
                                ";
                            }
                        ?>
                    </select>
            </div>


            <button type="submit" class="btn btn-primary">Додати</button>
        </form>
    </div>
</main>


<script src="/js/bootstrap.bundle.min.js"></script>
<script src="/js/bootstrap.validation.js"></script>
</body>
</html>