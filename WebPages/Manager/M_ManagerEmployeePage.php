<?php
session_start();
if($_SESSION["role"] != "Manager")
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
	<body class="managerBody">
	    
        <?php include('ManagerNavigationBar.php'); ?>
    
		<h1 align="center">Welcome in to the Grocery Store as Manager</h1>
		
		<table align='center'>
		    <tr><h2 align="center">Employees</h2></tr>
		    <tr><td align='center'><button onclick="location.href='M_AddEmployee.php'"><h4>Add Employee</h4></button></td>
		    </tr>
		</table>
		
		<?php include('M_EmployeeListDisplay.php'); ?>
		
		
	</body>
</html>