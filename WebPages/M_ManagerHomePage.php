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
		<link rel="stylesheet" type="text/css" href="CSS/stylesheet.css"/>
		<title>Grocery Store</title>
	</head>
	<body class="managerBody">
	   
    <div class="topnav">
        <a id='home' href="M_ManagerHomePage.php">Home</a>
        <a id='Employee' href="Manager/M_ManagerEmployeePage.php">Employees</a>
        
        <div>
            <button onclick="window.location.href = './Login.php';">logout</button>
        </div>        
    </div>

    
		<h1 align="center">Logged in to the Grocery Store</h1>
		<h2 align="center">Welcome Manager<br></h2>
		    <table class='table'>
		        <tr>
		            <td>Manager ID: </td> <td><?php echo $_SESSION['id']; ?></td>
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