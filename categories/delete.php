<?php

$id=$_GET["id"];
if($_SERVER["REQUEST_METHOD"]=="POST") {
    include($_SERVER["DOCUMENT_ROOT"] . "/connection.php");
    $sql = "SELECT * FROM categories WHERE id=$id";
    $categories = $dbh->query($sql);
    foreach ($categories as $cat){
        $imgOld = $cat["image"];
    }
    unlink($_SERVER["DOCUMENT_ROOT"] . '/uploads/'.$imgOld);

    $sql = "SELECT * FROM products WHERE category_id=$id";
    $products = $dbh->query($sql);
    foreach ($products as $product){
        $productId = $product["id"];

        $sql = "SELECT * FROM product_images WHERE product_id = $id;";
        $images = $dbh->query($sql);
        foreach ($images as $img){
            $file = $img['path'];
            unlink($_SERVER["DOCUMENT_ROOT"] . '/uploads/'.$img['path']);
            unlink('/uploads/643135f7f3d72.jpg');
        }

        $sql = "DELETE FROM `product_images` WHERE `product_images`.`product_id` = ?;";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([$productId]);

        $sql2 = "DELETE FROM products WHERE `products`.`id` = ?;";
        $stmt2 = $dbh->prepare($sql2);
        $stmt2->execute([$productId]);

    }







    $sql = "DELETE FROM `categories` WHERE `categories`.`id` = ?;";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$id]);
    //exit();
}
?>