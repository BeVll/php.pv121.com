<?php
$name = "";
$image = "";
$description = "";
$id=$_GET["id"];
include($_SERVER["DOCUMENT_ROOT"] . "/connection.php");
if($_SERVER["REQUEST_METHOD"]=="POST") {
    if (isset($_POST['name']))
        $name = $_POST['name'];
    if (isset($_POST['price']))
        $price = $_POST['price'];
    if (isset($_POST['description']))
        $description = $_POST['description'];
    if (isset($_POST['category_id']))
        $category_id = $_POST['category_id'];

    if (!empty($name) && !empty($price) && !empty($description) && !empty($category_id)) {
        $sql = "UPDATE `products` SET `name` = ?, `price` = ?, `description` = ?, `category_id` = ? WHERE `products`.`id` = ?;";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([$name, $price, $description, $category_id, $id]);
        $images = $_POST["images"];
        foreach ($images as $base64) {
            list(, $content) = explode(',', $base64);
            $bytes = base64_decode($content);
            $target_dir = $_SERVER["DOCUMENT_ROOT"] . "/uploads/"; //папка на сервері куди зберігаємо файл
            $fileName = uniqid() . ".jpg"; //унікальне імя для файлу
            $fileSave = $target_dir . $fileName; //місце збереження файлу
            file_put_contents($fileSave, $bytes);
            $main = false;
            $sql = 'INSERT INTO product_images (path, product_id, IsMain) VALUES(:path,:product_id,:IsMain);';
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':path', $fileName);
            $stmt->bindParam(':product_id', $id);
            $stmt->bindParam(':IsMain', $main);
            $stmt->execute();
        }
        header("location: /products/list.php");
        exit();
    }

}
if($_SERVER["REQUEST_METHOD"]=="GET") {
    $sql = "SELECT * FROM products where id=".$id;
    $command = $dbh->query($sql);
    foreach($command as $row) {
        $price = $row["price"];
        $name = $row["name"];
        $description = $row["description"];
        $category_id = $row["category_id"];
        break;
    }

    $sql = "SELECT * FROM categories";
    $categories = $dbh->query($sql);

    $sql = "SELECT * FROM product_images WHERE product_id=$id";
    $images2 = $dbh->query($sql);

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
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
<link rel="stylesheet" href="/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/font-awesome.min.css">
<link rel="stylesheet" href="/css/style.css">
<body>
<?php include($_SERVER["DOCUMENT_ROOT"] . "/_header.php"); ?>


<main>
    <div class="container">
        <h1 class="text-center">Змінить категорію</h1>
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
                <div class="row" id="listImages">
                    <?php
                    foreach ($images2 as $img){
                        $imgId = $img["id"];
                        $imgPath = $img["path"];
                            echo "
                                    <div class='col-md-2' id='img$imgId' style='position: relative'>
                                    <button type='button' onclick='deleteImg($imgId, `/products/deleteImg.php?id=$imgId`)' class='text-danger' style='position: absolute; right: 10px; top: 0px; z-index: 10' data-delete='$id'>
                                       <i class='fa fa-times fs-4'></i>
                                    </button>
                    <img src='/uploads/$imgPath'
                         style='cursor: pointer'
                         alt='фото категорії'
                         width='100%'>
                    <input type='hidden'
                           class='d-none'
                           value='/uploads/$imgPath'
                           name='fsd'> 
                            </div>";
                    }
                    ?>
                </div>

                <div class="col-md-2 mt-4">
                    <label for="image" class="form-label">
                        <img src="/uploads/upload.png"
                             style="cursor: pointer"
                             alt="фото категорії"
                             id="selectImage"
                             width="120">
                    </label>
                    <input type="file"
                           class="d-none"
                           id="image">
                </div>
                <div class="invalid-feedback">
                    Вкажіть шлях до фото товару
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
                <select class="form-select" name="category_id" id="category_id" aria-label="Default select example">
                    <?php
                    foreach ($categories as $cat){
                        $catId = $cat["id"];
                        $catName = $cat["name"];
                        if($catId == $category_id){
                            echo "
                                    <option value='$catId' selected>$catId - $catName</option>
                                ";
                        }
                        else{
                            echo "
                                    <option value='$catId'>$catId - $catName</option>
                                ";
                        }
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Зберегти</button>
        </form>
    </div>
</main>


<script src="/js/bootstrap.bundle.min.js"></script>
<script src="/js/bootstrap.validation.js"></script>
<script src="/js/axios.min.js"></script>
<script>
    function deleteImg(id, href){


        document.getElementById("img"+id).style.display = "none";
        axios.post(href).then(resp => {
            location.reload();
        });
    }
    window.addEventListener("load", (event) => {
        const image = document.getElementById("image");
        image.onchange = (e) => {
            const file = e.target.files[0];
            const fr = new FileReader();
            fr.addEventListener("load", () => {
                const base64 = fr.result;
                const data = `
                            <div class="col-md-2">
                                <img src="${base64}"
                                     style="cursor: pointer"
                                     alt="фото категорії"
                                     width="100%">
                                <input type="hidden"
                                       class="d-none"
                                       value="${base64}"
                                       name="images[]">
                            </div>`;

                document.getElementById("listImages").innerHTML += data;

            });
            fr.readAsDataURL(file);

            image.value = "";
        }
    });
</script>
</body>
</html>