<?php
require 'connection.php';
$vendor = $_GET["vendor"];

$sql = "SELECT * FROM bikes b INNER JOIN vendors v ON b.vendor_id = v.vendor_id WHERE v.vendor_name = :vendorName";
$stmt = $connectionC->prepare($sql);
$stmt->bindParam(':vendorName', $vendor);
$stmt->execute();

$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
header('Content-Type: text/plain');
foreach ($results as $row) {
    echo "Vendor Name: " . $row['vendor_name'] . "\n";
    echo "<li> Bike Name: " . $row['bike_name'] . "</li>\n";
    echo "<li>Bike Price: " . $row['bike_price'] . "</li>\n";
    echo "<li>Model Year: " . $row['model_year'] . "</li>\n";
    echo "<li>Bike Groupset: " . $row['bike_groopset'] . "</li>\n";
}
?>