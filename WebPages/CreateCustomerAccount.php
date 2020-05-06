<?php
  if (isset($_POST['submit'])) 
  {
    unset($_POST['submit']);
    $name = trim($_POST['name']);
    $email = strtolower($_POST['email']);
    $phone = $_POST['phone'];
    $pass = trim($_POST['password']);
    
    if(empty($name) || empty($email) || empty($phone) || empty($pass))
    {
        include('CreateCustomerAccount.php');
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
        
        $sql = "INSERT INTO Users (Email, Password, Name, Phone, Role) VALUES ('$email', '$pass', '$name', '$phone', 'Customer')";
        $result = $conn->query($sql);
        if($result != null && $result)
        {
            include("./Login.php");
            echo "<h3 align='center' style='color:green'>New Costumer  created.</h3>";
            exit;
        }
        else
        {
            echo "<h3 align='center' style='color:red'>User with that Email already exist. Please, try Again.</h3>";
            include("./CreateCustomerAccount.php");
            exit;
        }
    }
  }
  
?>


<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="CSS/stylesheet.css"/>
		<title>Grocery Store</title>
	</head>
	<body class='bodyDefault'>
		<h1 align="center">The Grocery Store</h1>
		<h2 align='center'>Create a new Customer Account</h2>
		
		<form method="post" action="">
    		<table class='table'>
    		    <tr>
    		        <td>Name</td> <td> <input type="text" name="name" required> </td>
    		    </tr>
    		    <tr>
    		        <td>Email</td> <td> <input type="email" name="email" required> </td>
    		    </tr>
    		    <tr>
    		        <td>Password</td> <td> <input type="password" name="password" required> </td>
    		    </tr>
    		    <tr>
    		        <td>Phone</td>
    		        <td><input type="tel" id="phone" name="phone" placeholder="123-456-7890" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" required></td>
    		    </tr>
    		    <tr>
			    <td><input type="submit" name="submit" value="create"></td>
			    <td><input type="button" value="cancel" onclick="window.location.href = './Login.php';"> </td>
			</tr>
    		</table>
		</form>
		
	</body>
</html>