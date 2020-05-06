<?php
session_start();
if($_SESSION["role"] != "Customer")
{
    header('HTTP/1.0 404 Unauthorized');
    exit;
}

if(isset($_POST['edit']))
{
    unset($_POST['save']);
    $editing = true;
    $editingItemId = $_POST['itemId'];
    
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
    
    $userId = $_SESSION['id'];
    $sql = "SELECT Count FROM Items WHERE ID=$editingItemId";
    
    $result = $conn->query($sql); 
    if($result != null && $result)
    {
        $row = $result->fetch_assoc();
        $max = $row['Count'];
    }
}
else if(isset($_POST['save']) && !empty($_POST['new_quantity']))
{
    unset($_POST['save']);
    $userId = $_SESSION['id'];
    $updatingItemId = $_POST['itemId'];
    $new_quantity = $_POST['new_quantity'];
    
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
    
    $sql = "UPDATE Cart 
            SET
                Quantity=$new_quantity
            WHERE 
	            User_Id=$userId
	            AND
	            Item_Id=$updatingItemId";
    
    $result = $conn->query($sql);
    
    if($result == null || !$result)
    {
        $msg = "Could not update the item please try again!";
    }
}
else if(isset($_POST['emptyCart']))
{
    unset($_POST['emptyCart']);
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
    
    $userId = $_SESSION['id'];
    $sql = "DELETE FROM Cart 
            WHERE 
	            User_Id = $userId";
    
    $result = $conn->query($sql);   
}

else if(isset($_POST['remove']))
{
    unset($_POST['remove']);
    $removingItemId = $_POST['itemId'];
    $userId = $_SESSION['id'];
    
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
    
    $sql = "DELETE FROM Cart 
            WHERE 
	            User_Id=$userId
	            AND
	            Item_Id=$removingItemId";
    
    $result = $conn->query($sql);
    
    if($result == null || !$result)
    {
        $msg = "Could not remove the item please try again!";
    }    
}

?>

<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="../CSS/stylesheet.css"/>
		<title>Grocery Store</title>
	</head>
	<body class="customerBody">
	    
	   <?php include('C_CustomerNavigationBar.php'); ?>
	   
	   <h2 align='center'>The Grocery Store</h2>
	   <h3 align='center'>Your Cart</h3>
	   
	   <table class='table'>
	       <tr>
	           <td style="width: 150px;">
	               <form method='post' action='C_CustomerCartPage.php' onSubmit="return confirm('Are you sure you wish to delete all the items?');">
        	       <button style='font-size:20px;' type='submit' name='emptyCart'>Empty Cart</button>
        	   </form>
	           </td>
	           <td>
	               <form method='post' action='C_CustomerCheckoutPage.php'>
            	       <button style='font-size:20px;' type='submit'>Check Out</button>
            	   </form>
	           </td>
	       </tr>
	   </table>
    	
    	<?php
    	    //Display User's cart details
            {
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
                $userId = $_SESSION['id'];
                $sql = "SELECT 
                            I.ID, I.Name, I.Category, I.Price, C.Quantity 
                        FROM 
                            Items as I, Cart as C
            	        WHERE 
            	            I.ID=C.Item_ID AND C.User_ID=$userId";
                
                
                $result = $conn->query($sql);
        ?>
                
                <h4 align='center'><?php echo $msg; ?></h4>
                
                <table class='listDispayTable'>
                <tr><th>S.No</th>
                    <th>Item ID</th>
                    <th>Item Name</th>
                    <th>Category</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Cost</th>
                    <th>Remove</th>
                </tr>
        <?php
                if($result != null && $result)
                {
                    $i=1;
                    $totalCost = 0;
                    while($row = $result->fetch_assoc())
                    {
                        $itemId = $row['ID'];
                        $itemName = $row['Name'];
                        $category = $row['Category'];
                        $unitPrice = $row['Price'];
                        $quantity = $row['Quantity'];
                        $cost = $unitPrice*$quantity;
                        $totalCost += $cost; 
                ?>
                        <tr>
                            <form method='post' action='C_CustomerCartPage.php'>
                                
                              <input type='hidden' name='itemId' value=<?php echo $itemId; ?>>
                              <input type='hidden' name='itemName' value=<?php echo $itemName; ?>>
                              <input type='hidden' name='category' value=<?php echo $category; ?>>
                              <input type='hidden' name='price' value=<?php echo $unitPrice; ?>>
                              <input type='hidden' name='quantity' value=<?php echo $quantity; ?>>
                              
                              <td><?php echo $i; ?></td>
                              <td><?php echo $itemId; ?></td>
                              <td><?php echo $itemName; ?></td>
                              <td><?php echo $category; ?></td>
                              <td>$<?php echo $unitPrice; ?></td>
                              
                <?php           if($editing && $editingItemId==$itemId)
                                {
                                    echo "<td><input value=$quantity type='number' style='font-size:20px;' min=1 max=$max name='new_quantity'>
                                    <button type='submit' name='save' style='font-size:15px;'> (Save Max:$max)</button></td>";
                                }
                                else
                                {
                                    echo "<td>$quantity
                                    <button type='submit' name='edit' style='font-size:15px;'> (Edit)</button></td>";
                                }
                ?>          
                            <td>$<?php echo $cost ?></td>
                            <td><button type='submit' style='font-size:20px;' name='remove'>Remove</button></td>
                            </form>
                        </tr>
                <?php   $i++;
                    }
        ?>
                <tr style='background-color:#e3ce49; font-size:20px;'>
                    <td colspan=6>Total</td>
                    <td colspan=2>$<?php echo $totalCost; ?></td>
                </tr>
            
        <?php
                }
            }
    	?>
    	
	</body>
</html>