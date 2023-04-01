<?php

$id=$_GET["id"];
if($_SERVER["REQUEST_METHOD"]=="POST") {
    include($_SERVER["DOCUMENT_ROOT"] . "/connection.php");
    $sql = "DELETE FROM `categories` WHERE `categories`.`id` = ?;";
    $stmt = $dbh->prepare($sql);
    $stmt->execute([$id]);
    //exit();
}
?>