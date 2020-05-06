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
	    
    <div class="topnav">
        <a id='home' href="../A_AdminHomePage.php">Home</a>
        <a id='manager' href="A_AdminManagerPage.php">Managers</a>
        
        <div>
            <button onclick="window.location.href = '../Login.php';">logout</button>
        </div>        
    </div>
    </body>
</html>