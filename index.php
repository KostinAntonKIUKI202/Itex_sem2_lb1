<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lb 2.1</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <h1>Лабораторна робота: 1</h1>
    <h3>Ванріант: 5</h3>

    <hr class="solid">
    <header>
        <h3 class='m-5'>Bike Shop</h4>
    </header>

    <div class='mainBody'>
        <div class='navBar'>
            <h4 class='m-2'>Filter</h5>
            <hr class="solid">
            <div class='m-2'>
                <form action="index.php" method="post">
                <h5>Виробник:</h5>
                <?php
                    $sqlC = 'SELECT * FROM vendors ORDER BY vendor_id ASC';

                    //Вся информация которая нам требуется для подключения к БД
                    $host = 'localhost';
                    $DB = 'Shop_Lb1';
                    $user = 'root';
                    $password = '';

                    //подключение к БД
                    $connectionC = new PDO('mysql:host='.$host.';dbname='.$DB.';', $user, $password);

                    foreach ($connectionC->query($sqlC) as $row) {
                       echo ( '<input id="checkbox" type="checkbox" name="vendors[]" value = "'.$row['vendor_id'].'" />'.$row['vendor_name'].'</br>');
                    }
                 ?>
            </div>
            <div class='m-2'>
                <h5>Категорії  товарів:</h5>
                <?php
                    $sqlC = 'SELECT * FROM categories ORDER BY category_id ASC';

                    $host = 'localhost';
                    $DB = 'Shop_Lb1';
                    $user = 'root';
                    $password = '';

                    $connectionC = new PDO('mysql:host='.$host.';dbname='.$DB.';', $user, $password);

                    foreach ($connectionC->query($sqlC) as $row) {
                       echo ( '<input id="checkbox" type="checkbox" name="categories[]"value = "'.$row['category_id'].'"/>'.$row['category_name'].'</br>');
                    }
                 ?>
            </div>
            <div class='m-2'>
                <h5>Ціна:</h5>
                <label>Від:</label>
                <input type="number" name='price[]' class='w-100'/>
                <br>
                <br>
                <label>До:</label>
                <input type="number" name='price[]' class='w-100'/>
            </div>
            <div class = 'text-center'>
                <form method="POST" >
                  <input type="submit" name="submit" value="Filter" class="'m-2 mb-3 w-75">
                </form>
            </div>
        </form>
        </div>
    <?php
    $connection = new PDO('mysql:host=localhost;dbname=Shop_Lb1','root','');
    class Item {
        //atributes
        private $bike_name;
        private $category;
        private $vendor;
        private $price;
        private $model_year;
        private $groopset;
        function __construct($bike_name, $category, $vendor, $price, $model_year, $groopset){
            $this->bike_name = $bike_name;
            $this->set_category($category);
            $this->set_brand($vendor);
            $this->price = $price;
            $this->model_year = $model_year;
            $this->groopset = $groopset;
        }

        function get_name() {
            return $this->bike_name;
        }
        function set_name($bike_name) {
            $this->bike_name = $bike_name;
        }

        function get_category() {
            return $this->category;
        }
        function set_category($category) {
            $host = 'localhost';
            $DB = 'Shop_Lb1';
            $user = 'root';
            $password = '';
            $pdo = new PDO('mysql:host='.$host.';dbname='.$DB.';', $user, $password);

            $query = 'SELECT category_name FROM categories WHERE category_id ='.$category;
            $stmt = $pdo->prepare($query);
            $stmt->bindValue(':category',$category);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->category = $row['category_name'];
        }

        function get_brand() {
            return $this->vendor;
        }
        function set_brand($vendor) {
            $host = 'localhost';
            $DB = 'Shop_Lb1';
            $user = 'root';
            $password = '';
            $pdo = new PDO('mysql:host='.$host.';dbname='.$DB.';', $user, $password);

            $query = 'SELECT vendor_name FROM vendors WHERE vendor_id ='.$vendor;
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->vendor = $row['vendor_name'];
        }

        function get_price() {
            return $this->price;
        }
        function set_price($price) {
            $this->price = $price;
        }

        function get_model_year() {
            return $this->model_year;
        }
        function set_model_year($model_year) {
            $this->model_year = $model_year;
        }

        function get_groopset() {
            return $this->groopset;
        }
        function set_groopset($groopset) {
            $this->groopset = $groopset;
        }

        function to_string()
            {
                return "Product name: {$this->get_name()} Model year: {$this->get_model_year()} Groopset: {$this->get_groopset()}  Category: {$this->get_category()} Vendor: {$this->get_brand()} Price: {$this->get_price()}\n\t";
            }
 }

 $store = array();

 function setItems ($sql){
     global $connection;
     global $store;
     $store = array();
     foreach ($connection->query($sql) as $row) {
         $store[] = new Item ($row['bike_name'],$row['category_id'],$row['vendor_id'],$row['bike_price'],$row['model_year'],$row['bike_groopset']);
     }

 }
//-----------------------------------------------
$vendors = $_POST['vendors'];
$categories = $_POST['categories'];
$price = $_POST['price'];

$sqlRequest = 'SELECT * FROM bikes WHERE ';
if(empty($vendors))
{
 echo("Ви не обрали ніодного виробника.\n");
}
else
{

 $N = count($vendors);
 for($j=0; $j < $N; $j++)
 {
   $sqlRequest .= '(vendor_id = '.$vendors[$j].' )';
   if ($j != $N-1){
     $sqlRequest .= ' OR ';
   }
 }
 if(!(empty($categories) && $price[0]==0 && $price[1]==0)){
     $sqlRequest .= ' AND ';
 }

}
//-----------------------------------------


if(empty($categories))
{
 echo("Ви не обрали ніодної категорії.\n");
}
else
{

 $N = count($categories);


 for($i=0; $i < $N; $i++)
 {
   $sqlRequest .= '(category_id = '.$categories[$i].' )';
   if ($i != $N-1){
     $sqlRequest .= ' OR ';
   }
 }
 if(!($price[0]==0 && $price[1]==0)){
     $sqlRequest .= ' AND ';
 }


}

if(empty($price))
{

}
else
{
 if ($price[0]>0){
    $sqlRequest .= '( bike_price >= '.$price[0].' ) ';
 }
 if ($price[0]>0 && $price[1]>0){
     $sqlRequest .= ' AND ';
 }

 if ($price[1]>0){
    $sqlRequest .= '( bike_price < '.$price[1]. ' ) ';
 }
 echo $sqlRequest;
}

if (empty($vendors) && empty($categories) && $price[0]==0 && $price[1]==0){
 $sqlRequest = 'SELECT * FROM bikes ORDER BY bike_id ASC';
}

setItems($sqlRequest);

?>
<main>
    <h4>main</h4>
    <?php
        //Данные из БД
        foreach ($store as $item){
            echo nl2br ($item->to_string());
        }
    ?>
</main>
</body>

</html>