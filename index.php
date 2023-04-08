<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Головна сторінка</title></head>
<link rel="stylesheet" href="/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/font-awesome.min.css">
<link rel="stylesheet" href="/css/style.css">
<body>
<?php include($_SERVER["DOCUMENT_ROOT"] . "/_header.php"); ?>

<?php include($_SERVER["DOCUMENT_ROOT"] . "/connection.php"); ?>

<main>
    <div class="container">
        <h1 class="text-center">Список категорій</h1>
        <a href="/categories/create.php" class="btn btn-success">Додати категорію</a>
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Фото</th>
                <th scope="col">Навва</th>
                <th scope="col">Опис</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php
            $sql = "SELECT * FROM categories";
            $command = $dbh->query($sql);
            foreach($command as $row) {
                $name = $row["name"];
                $id = $row["id"];
                $image = $row["image"];
                $description = $row["description"];
                echo "
                <tr>
                    <td><img src='/uploads/$image' width='50'/></td>
                    <td>$name</td>
                    <td>$description</td>
                    <td>
                        <a href='/categories/edit.php?id=$id' class='text-primary' style='text-decoration: none;'>
                           <i class='fa fa-pencil fs-4'></i>
                        </a>
                        &nbsp;
                        <a href='/categories/delete.php?id=$id' class='text-danger' data-delete='$id'>
                           <i class='fa fa-times fs-4'></i>
                        </a>
                    </td>
                </tr>
                ";
            }
            ?>

            </tbody>
        </table>
    </div>
</main>

<?php include($_SERVER["DOCUMENT_ROOT"] . "/modals/deleteModal.php"); ?>


<script src="/js/bootstrap.bundle.min.js"></script>
<script src="/js/axios.min.js"></script>
<script>
    window.addEventListener("load", (event) => {
        let idDelete=0;
        let linkTo="";
        const delBtns = document.querySelectorAll("[data-delete]");
        var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        for(let i=0;i<delBtns.length; i++) {
            delBtns[i].onclick = function(e) {
                e.preventDefault();
                idDelete = this.dataset.delete;
                linkTo = this.href;
                console.log("Click item", idDelete);
                console.log("Link to", linkTo);
                deleteModal.show();
            }
        }
        //натиснули на кнопку видалити у модалці
        document.getElementById("modalDeleteYes").onclick = function() {
            console.log("Delete yes modal", idDelete);
            axios.post(linkTo).then(resp => {
                deleteModal.hide();
                location.reload();
            });


        }

    });

</script>
</body>
</html>