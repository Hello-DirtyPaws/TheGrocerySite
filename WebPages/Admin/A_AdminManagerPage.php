<?php
session_start();
if($_SESSION["role"] != "Admin")
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
	<body class="adminBody">
	    
        <?php include('AdminNavigationBar.php'); ?>

		<h1 align="center">Welcome in to the Grocery Store as Admin</h1>
		
		<table align='center'>
		    <tr><h2 align="center">Managers</h2></tr>
		    <tr><td align='center'><button onclick="location.href='A_AddManager.php'"><h4>Add Manager</h4></button></td>
		    </tr>
		</table>
		
		<?php include('A_ManagerListDisplay.php'); ?>
		
		
	</body>
</html>