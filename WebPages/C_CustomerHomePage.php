<?php
session_start();
if($_SESSION["role"] != "Customer")
{
    header('HTTP/1.0 404 Unauthorized');
    exit;
}
?>

<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="CSS/stylesheet.css"/>
		<title>Grocery Store</title>
	</head>
	<body class="customerBody">
	   
    <div class="topnav">
            <a href="C_CustomerHomePage.php">Home</a>
            <a href="Customer/C_CustomerShopPage.php">Shop</a>
            <a href="Customer/C_CustomerCartPage.php">Cart</a>
            <a href="Customer/C_CustomerCheckoutPage.php">Check out</a>
            <a href="Customer/C_CustomerOrders.php">Orders</a>
        
        <div>
            <button onclick="window.location.href = './Login.php';">logout</button>
        </div>        
    </div>

    
		<h1 align="center">Logged in to the Grocery Store</h1>
		<h2 align="center">Welcome Customer<br></h2>
		    <table class='table'>
		        <tr>
		            <td>Customer ID: </td> <td><?php echo $_SESSION['id']; ?></td>
		        </tr>
		        <tr>
		            <td>Name: </td> <td><?php echo $_SESSION['name']; ?></td>
		        </tr>
		        <tr>
		            <td>Phone: </td> <td><?php echo $_SESSION['phone']; ?></td>
		        </tr>
		        <tr>
		            <td>Email: </td> <td><?php echo $_SESSION['email']; ?></td>
		        </tr>
		    </table>
		
	</body>
</html>