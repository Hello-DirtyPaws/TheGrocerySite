<?php
session_start();
if($_SESSION["role"] != "Customer")
{
    header('HTTP/1.0 404 Unauthorized');
    exit;
}

//DB Connection
{
  $servername = "127.0.0.1:3306"; 
  $username = "root";
  $password = "password";
  $dbname = "thoutas1_Grocery_Strore";
  $conn = new mysqli($servername, $username, $password, $dbname);
  
  // Check connection
  if ($conn->connect_error) 
  {
    die("Connection failed: " . $conn->connect_error);
  }
  //echo "Connected successfully <br>";
}

$sql = "Select Name, ID, Count, Category, Price from Items";

$searchToken = trim($_SESSION['searchToken']);
$categoryToken = trim($_SESSION['categoryToken']);


if(!empty($searchToken))
{
    $sql = $sql." where Name like '%$searchToken%'";
}
else if(!empty($categoryToken) && $categoryToken != 'All')
{
    $sql = $sql." where category = '$categoryToken'";
}

$sql = $sql." ORDER BY id";

$result = $conn->query($sql);

//table begins
echo "<table class='listDispayTable'>";
echo "<tr> <th>S.No</th><th>Item ID</th><th>Name</th>
           <th>Category</th><th>Unit Price</th>
           <th>Quantity(/Max Available)</th><th>Add to Cart</th>
    </tr>";
if($result != null && $result)
{
    $i=1;
    while($row = $result->fetch_assoc())
    {
        $id = $row['ID'];
        $max = $row['Count'];
        echo "<tr>
                <form method='post' action='C_CustomerShopPage.php'>
                  <input type='hidden' name='itemId' value=$id>
                  <td>$i</td>   <td>$id</td><td>".$row['Name']."</td>
                  <td>".$row['Category']."</td><td>$".$row['Price']."</td>
                  <td><input name='quantity' style='font-size:20px;' value=1 type='number' min=1 max=$max>(/$max)</td>
                  <td><button style='font-size:20px;' type='submit' name='addToCart'>Add</button></td>
                </form>
              </tr>";
        $i++;
    }
}
else
{
    //No Items   
}

//table ends
echo "</table>";

if(isset($_SESSION['searchToken']))
{
    unset($_SESSION['searchToken']);
}
if(isset($_SESSION['categoryToken']))
{
    unset($_SESSION['categoryToken']);
}
?>