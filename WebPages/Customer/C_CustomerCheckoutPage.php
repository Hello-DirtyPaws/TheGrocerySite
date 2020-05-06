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

//CALCULATE THE TOTAL FROM THE CART AND THE ITEMS TABLE TO PASS ON TO THE DB -> ORDERS TABLE.
$total = 0;

$userId = $_SESSION['id'];

$sql = "SELECT C.Item_ID, C.Quantity, I.Price 
        FROM Cart as C, Items as I
        WHERE 
            C.Item_ID = I.ID 
            AND
            C.User_ID = $userId";
            
$result = $conn->query($sql);

if($result != null && $result)
{
    while($row = $result->fetch_assoc())
    {
        $total = $total + $row['Quantity']*$row['Price'];
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
    
		<h2><center> Pay online</h2>
		<h3><center> Please enter your personal infomation and credit card information to place the order</h3>
		
		<table align="center" style="margin: 0px auto;">
    		<tr>
        		<th>Name:
        		<select>
        				<option> Mr.</option>
        				<option> Mrs.</option>
        				<option> Ms.</option>
        		</select></th>
        		<th><?php echo $_SESSION['name']; ?></th>
        	</tr>
    		<tr>
    		    <th>Email Address:</th>
    		    <th><?php echo $_SESSION['email']; ?></th>
    		</tr>
    		<tr>
    		    <th>Phone Number:</th>
    		    <th><?php echo $_SESSION['phone']; ?></th>
    		</tr>
		</table>
		
		<table align="center">
		    <form method='post' action='C_CustomerOrders.php'>
    			<tr> 
    				<th>Name On Card : </th>
    				<th> <input type="text" required/></th>
   </tr>
    			<tr>
    				<th> Card Number : </th>
    				<th> <input type="text" required/></th>
   </tr>	
    			<tr> 
    				<th>Expiration Date : </th>
    				<th> <input type="date" required/></th>
   </tr>
    			<tr> 
    				<th>CVV : </th>
    				<th><input type="number" size="4" required/></th>
   </tr>
    			<tr>
    			    <td style="font-size:25px;" colspan=2>
    			        <center>Total: $<?php echo $total; ?></center>
    			    </td>
   </tr>
        		<tr>
            		<th colspan=2 align='center'>
            <?php
                    if($total > 0)
                    {
            ?>            
        		        <input type='hidden' name='total' value='<?php echo $total; ?>'>
        		        <button style="font-size:20px; background-color:#bfbabe;" type="submit" name='orderPlaced'>Place your order</button>
            <?php   }
                    else
                    {
                        echo "Cart is Empty! No order to place.";
                    }
            ?>
            		 </th>
                </tr>
            </form>
		</table>

        <br>
        
        <form align='center' method='post' action='C_CustomerShopPage.php'>
            <button type='submit' style="font-size:20px;">Continue Shopping</button>
        </form>

	</body>
</html>