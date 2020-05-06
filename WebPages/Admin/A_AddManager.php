<?php
session_start();

if($_SESSION["role"] != "Admin")
{
    header('HTTP/1.0 404 Unauthorized');
    exit;
}

  if (isset($_POST['submit'])) 
  {
    unset($_POST['submit']);
    $name = $_POST['name'];
    $email = strtolower($_POST['email']);
    $phone = $_POST['phone'];
    $pass = $_POST['password'];
    
    if(empty($name) || empty($email) || empty($phone) || empty($pass))
    {
        include('A_AddManager.php');
        echo "<h3 align='center' style='color:red'>Please fill out all the detalis.</h3>";
        exit;
    }
    else
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
        $pass = sha1($pass);
        $sql = "INSERT INTO Users (Email, Password, Name, Phone, Role) VALUES ('$email', '$pass', '$name', '$phone', 'Manager')";
        $result = $conn->query($sql);
        if($result != null && $result)
        {
            include("./A_AdminManagerPage.php");
            echo "<h3 align='center' style='color:green'>New Manager added.</h3>";
            exit;
        }
        else
        {
            include('A_AddManager.php');
            echo "<h3 align='center' style='color:red'>User with that Email already exist. Please, try Again.</h3>";
            exit;
        }
      }
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
	    
		<h1 align="center">The Grocery Store</h1>
		<h2 align="center">Add a new Manager Account</h2>
		
		<form method="post" action="">
    		<table class='table'>
    		    <tr>
    		        <td>Name</td> <td> <input type="text" name="name"> </td>
    		    </tr>
    		    <tr>
    		        <td>Email</td> <td> <input type="email" name="email"> </td>
    		    </tr>
    		    <tr>
    		        <td>Password</td> <td> <input type="password" name="password"> </td>
    		    </tr>
    		    <tr>
    		        <td>Phone</td>
    		        <td><input type="tel" id="phone" name="phone" placeholder="123-456-7890" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required></td>
    		    </tr>
    		    <tr>
			    <td><input type="submit" name="submit" value="create"></td>
			    <td><input type="button" value="cancel" onclick="window.location.href = './A_AdminManagerPage.php';"> </td>
			</tr>
    		</table>
		</form>
		
	</body>
</html>