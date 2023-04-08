<?php

$id=$_GET["id"];
if($_SERVER["REQUEST_METHOD"]=="POST") {
    include($_SERVER["DOCUMENT_ROOT"] . "/connection.php");
    $sql = "SELECT * FROM product_images WHERE id = $id;";
    $images = $dbh->query($sql);
    foreach ($images as $img){
        $file = $img['path'];
        unlink($_SERVER["DOCUMENT_ROOT"] . '/uploads/'.$file);
    }


    $sql = "DELETE FROM `product_images` WHERE `product_images`.`id` = ?;";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$id]);

}
?>