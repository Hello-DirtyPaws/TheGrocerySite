<?php
session_start();
if($_SESSION["role"] != "Customer")
{
    header('HTTP/1.0 404 Unauthorized');
    exit;
}

$orderId = $_POST['orderId'];
$total = $_POST['total'];
?>

<html>
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="../CSS/stylesheet.css"/>
	<title>Grocery Store</title>
</head>
<body class="customerBody">
    <?php include('C_CustomerNavigationBar.php'); ?>

	<h1 align="center">The Grocery Store</h1>
	<h2 align="center">Order Details<br></h2>

    <h4 align="center">Order ID: <?php echo $orderId; ?><br></h4>
    
    <form align='center' method='post' action='./C_CustomerOrders.php'>
        <button style="font-size:20px; background-color:#bfbabe;" type='submit'>Back to All Orders</button>
    </form>
    
    <table class='listDispayTable'>
        <tr><th>S.No</th><th>Item ID</th><th>Item Name</th>
            <th>Unit Item Price</th><th>Quantity</th>
            <th>Cost</th>
        </tr>
    <?php
    //Display Orders List
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
        
        $sql = "Select * from Items_Ordered WHERE Order_ID = $orderId";
        
        $result = $conn->query($sql);
        
        if($result != null && $result)
        {
            $i=1;
            while($row = $result->fetch_assoc())
            {
                $quantity = $row['Item_Quantity'];
                $unitPrice = $row['Item_Price'];
                $cost = $quantity*$unitPrice;
                
                echo "<tr>
                          <td>$i</td>
                          <td>".$row['Item_ID']."</td><td>".$row['Item_Name']."</td>
                          <td>$$unitPrice</td><td>$quantity</td>
                          <td>$$cost</td>
                      </tr>";
                $i++;
            } 
    ?>
            <tr style='background-color:#e3ce49; font-size:20px;'>
                <td align='center' colspan=5>Total</td>
                <td align='center'>$<?php echo $total; ?></td>
            </tr>
            
    <?php    
        }
    }
?>