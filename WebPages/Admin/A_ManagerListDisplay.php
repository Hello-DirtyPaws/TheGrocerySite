<?php
    
session_start();
if($_SESSION["role"] != "Admin")
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

$sql = "Select Name, ID, Phone, Email from Users where Role='Manager'";
$result = $conn->query($sql);

//table begins
echo "<table class='listDispayTable'>";
echo "<tr> <th>S.No</th><th>Manager ID</th><th>Manager Name</th>
           <th>Manager Phone</th><th>Manager Email</th> 
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
                  <td>".$row['Phone']."</td><td>".$row['Email']."</td>
                  <td><a href='A_EditManager.php?id=$id'>Edit</a></td>
                  <td><a href='A_DeleteManager.php?id=$id'>Delete</a></td>
              </tr>";
        $i++;
    }
}
else
{
    //No Managers   
}

//table ends
echo "</table>";
?>