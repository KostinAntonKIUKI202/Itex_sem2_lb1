<?php
require 'connection.php';
$category_id = $_GET["category_id"];

$sql = "SELECT * FROM bikes b INNER JOIN categories v ON b.category_id = v.category_id WHERE v.category_id = :category_id";
$stmt = $connectionC->prepare($sql);
$stmt->bindParam(":category_id", $category_id);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
header('Content-Type: text/xml');
echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
echo '<products>';
foreach ($results as $row) {
    echo '<product>' . $row['bike_name'] . " price : " . $row['bike_price'] . '</product>';
}
echo '</products>';
?>
