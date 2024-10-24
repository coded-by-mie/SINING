<?php
include 'condb.php';

$order_id = $_POST['order_id'];
$select = mysqli_query($conn, "DELETE FROM `getgcash`") or die('query failed');

$insert = mysqli_query($conn, "INSERT INTO `getgcash`(order_id) VALUES ('$order_id')") or die('query failed');
echo ($id);
?>