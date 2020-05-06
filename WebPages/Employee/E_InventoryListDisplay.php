<?php
session_start();
if($_SESSION["role"] != "Admin" && $_SESSION["role"] != "Manager" && $_SESSION["role"] != "Employee")
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

$sql = "Select Name, ID, Count, Category, Price from Items"; // where Role='Employee'";

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
           <th>Category</th><th>Price</th><th>Count</th> 
           <th>edit</th><th>delete</th>
    </tr>";
if($result != null && $result)
{
    $i=1;
    while($row = $result->fetch_assoc())
    {
        $id = $row['ID'];
        echo "<tr>
                  <td>$i</td>
                  <td>".$id."</td><td>".$row['Name']."</td>
                  <td>".$row['Category']."</td><td>$".$row['Price']."</td>
                  <td>".$row['Count']."</td>
                  <td><a href='E_EditItem.php?id=$id'>Edit</a></td>
                  <td><a href='E_DeleteItem.php?id=$id'>Delete</a></td>
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