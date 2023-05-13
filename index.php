<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
		<title>LB3</title>
	</head>
	<body>
		<h1>Лабораторна робота: 3</h1>
		<h3>Варіант: 5</h3>
		<hr class="solid">
		<header>
			<h3 class='m-5'>Bike Shop</h4>
		</header>
		<div class='mainBody'>
			<div class='navBar'>
				<hr class="solid">
				<h4 class='m-2'>Filter</h4>
				<hr class="solid">
				<div class='m-2'>
					<h5>Товари обраного виробника:</h5>
					<select id="vendor">
					<?php
						require 'connection.php';
						try {
						$sql = "SELECT * FROM vendors ORDER BY vendor_id ASC";
						$stmt = $connectionC->prepare($sql);
						$stmt->execute(); 
						$nurses = $stmt->fetchAll(PDO::FETCH_ASSOC);
						foreach ($nurses as $nurse) {
							echo '<option>' . $nurse['vendor_name'] . '</option>';
						}
						} catch (PDOException $ex) {
							echo $ex->getMessage(); 
						}
					?>
					</select>
					<button onclick="getText()" >Отримати (Text)</button>
					<div id="vendorRes"></div>
					
					<h5>Товари в обраної категорії:</h5>
					<select id="category">
					<?php
						require 'connection.php';
						try {
						$sql = "SELECT * FROM categories ORDER BY category_id ASC";
						$stmt = $connectionC->prepare($sql);
						$stmt->execute(); 
						$departments = $stmt->fetchAll(PDO::FETCH_ASSOC); 
						foreach ($departments as $department) {
							echo '<option>' . $department['category_id'] . " " . $department['category_name'] . '</option>';
						}
						} catch (PDOException $ex) {
							echo $ex->getMessage(); 
						}
						?>
					</select>
					<button onclick="getXML()" >Отримати (XML)</button>
					<div id="categoryRes"></div>

					<h5>Товари в обраному ціновому діапазоні:</h5>
					<label>Від:</label>
					<input type="number" value="1000" id="low_price" class="w-20"/>
					<label>До:</label>
					<input type="number" value="20000" id="max_price" class="w-20"/>
					<button onclick="getJSON()" >Отримати (JSON)</button>
					<div id="priceRes"></div>
				</div>
			</div>
		</div>
		<script>
			const ajax = new XMLHttpRequest();

			function getText(){
				const vendor = document.getElementById('vendor').value;
				ajax.open('GET', 'goodsVendor.php?vendor=' + vendor);
				ajax.onreadystatechange = function() {
					if (ajax.readyState === 4 && ajax.status === 200) {
						document.getElementById('vendorRes').innerHTML = ajax.response;
						}
					}
				ajax.send();
			}

			function getXML(){
				const category = document.getElementById('category').value;
				ajax.open('GET', 'goodsByCategory.php?category_id=' + category);
				ajax.onreadystatechange = function() {
					if (ajax.readyState === 4 && ajax.status === 200) {
						const nodes = ajax.responseXML.getElementsByTagName('product');
						let res = "";
						for (let i = 0; i < nodes.length; i++) {
							res += '<li>' + nodes[i].childNodes[0].nodeValue + '</li>';
						}
						document.getElementById('categoryRes').innerHTML = res;
						}
					}
				ajax.send();
			}

			function getJSON(){
				const low_price = document.getElementById('low_price').value;
				const max_price = document.getElementById('max_price').value;
				ajax.open('GET', 'goodsByPrice.php?low_price=' + low_price + "&max_price=" + max_price);
				ajax.onreadystatechange = function() {
					if (ajax.readyState === 4 && ajax.status === 200) {
						const data = JSON.parse(ajax.responseText);
						let res = "";
						data.forEach((item) => {
							res += '<li>' + 'Name: '+ item.bike_name + ' - Price: ' + item.bike_price  + '</li>';
						});
						document.getElementById('priceRes').innerHTML = res;
						}
					}
				ajax.send();
			}
		</script>
		</body>
</html>
