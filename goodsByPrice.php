<?php
require 'connection.php';
$low_price = $_GET["low_price"];
$max_price = $_GET["max_price"];

$sql = "SELECT bike_price, bike_name FROM bikes WHERE bike_price BETWEEN :low_price AND :max_price";
$stmt = $connectionC->prepare($sql);
$stmt->bindParam(':low_price', $low_price);
$stmt->bindParam(':max_price', $max_price);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
header('Content-Type: application/json');
echo json_encode($results);
?>