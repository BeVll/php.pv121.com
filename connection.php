<?php
$user="root";
$pass="";
try {
    $dbh = new PDO("mysql:host=localhost;dbname=shop;port=3306",$user,$pass);
}catch(Exception $ex) {
    print "Error! ".$ex->getMessage(). "<br/>";
    exit();
}