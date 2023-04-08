<?php

$id=$_GET["id"];
if($_SERVER["REQUEST_METHOD"]=="POST") {
    include($_SERVER["DOCUMENT_ROOT"] . "/connection.php");
    $sql = "SELECT * FROM product_images WHERE product_id = $id;";
    $images = $dbh->query($sql);
    foreach ($images as $img){
        $file = $img['path'];
        unlink($_SERVER["DOCUMENT_ROOT"] . '/uploads/'.$img['path']);
        unlink('/uploads/643135f7f3d72.jpg');
    }


    $sql = "DELETE FROM `product_images` WHERE `product_images`.`product_id` = ?;";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$id]);

    $sql = "DELETE FROM `products` WHERE `products`.`id` = ?;";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$id]);

    //exit();
}
?>