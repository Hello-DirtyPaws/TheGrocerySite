<?php
session_start();
if($_SESSION["role"] != "Admin" && $_SESSION["role"] != "Manager" && $_SESSION["role"] != "Employee")
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
	<body>
        <div class="topnav">
            <a href="../E_EmployeeHomePage.php">Home</a>
            <a href="E_EmployeeInventoryPage.php">Inventory</a>
            <a href="E_ManageCategories.php">Manage Categories</a>
            <a href="E_AllOrders.php">Orders</a>
            <div>
                <button onclick="window.location.href = '../Login.php';">logout</button>
            </div>        
        </div>
	</body>
</html>