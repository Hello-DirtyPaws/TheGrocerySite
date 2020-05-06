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
		<link rel="stylesheet" type="text/css" href="CSS/stylesheet.css"/>
		<title>Grocery Store</title>
	</head>
	<body class="adminBody">
	   
    <div class="topnav">
        <a href="A_AdminHomePage.php">Home</a>
        <a href="Admin/A_AdminManagerPage.php">Managers</a>
        
        <div>
            <button onclick="window.location.href = './Login.php';">logout</button>
        </div>        
    </div>

    
		<h1 align="center">Logged in to the Grocery Store</h1>
		<h2 align="center">Welcome Admin<br></h2>
		    <table class='table'>
		        <tr>
		            <td>Admin ID: </td> <td><?php echo $_SESSION['id']; ?></td>
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