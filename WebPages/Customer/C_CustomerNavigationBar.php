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
		<link rel="stylesheet" type="text/css" href="../CSS/stylesheet.css"/>
		<title>Grocery Store</title>
	</head>
	<body class='customerBody'>
	    
        <div class="topnav">
            <a href="../C_CustomerHomePage.php">Home</a>
            <a href="C_CustomerShopPage.php">Shop</a>
            <a href="C_CustomerCartPage.php">Cart</a>
            <a href="C_CustomerCheckoutPage.php">Check out</a>
            <a href="C_CustomerOrders.php">Orders</a>
            <div>
                <button onclick="window.location.href = '../Login.php';">logout</button>
            </div>        
        </div>
	</body>
</html>