<?php
session_start();
if(isset($_SESSION['role']))
{
    $_SESSION['role']='';
    session_destroy();
}
if(isset($_POST['submit']))
{
    //DB CONNECTION
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
    
    $email = strtolower(trim($_POST['email']));
    $password = $_POST['password'];
    
    
    $sql = "SELECT Role, ID, Name, Phone, Email FROM Users WHERE email='". $email. "' AND password= '".sha1($password)."'";
    
    
    $result = $conn->query($sql);
    if($result != null && $result)
    {
        $row = $result->fetch_assoc();
        $role = $row["Role"];
    
        session_start();
        $_SESSION["id"] = $row["ID"];
        $_SESSION["name"] = $row["Name"];
        $_SESSION["phone"] = $row["Phone"];
        $_SESSION["email"] = $row["Email"];
        $_SESSION["role"] = $role;
    
        switch($role)
        {
            case "Admin": 
                include("A_AdminHomePage.php"); 
                exit;
            case "Manager":
                include("M_ManagerHomePage.php"); 
                exit;
            case "Employee": 
                include("E_EmployeeHomePage.php"); 
                exit;
            case "Customer": 
                include("C_CustomerHomePage.php"); 
                exit;
            default:
                session_destroy();
                include("InvalidLoginPage.html");
                exit;
        }
    }
    else
    {
        session_destroy();
        include("InvalidLoginPage.html");
        exit;
    }
    $conn->close();
}
?>



<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="CSS/stylesheet.css"/>
		<title>Grocery Store</title>
	</head>
	<body class="bodyDefault">
		<h1 align="center">Welcome to the Grocery Store</h1>
		<form method="post" action="Login.php">
		<table class='table'>
			<tr>
			    <td>Email:</td><td><input type="text" name="email"/></td>
			</tr>
			<tr>
			    <td>Password:</td><td><input type="password" name="password"></td>
			</tr>
			<tr>
			    <td><input type="submit" name="submit"></td><td> <input type="button" value="Create a New Customer Account" onclick="window.location.href = './CreateCustomerAccount.php';" > </td>
			</tr>
		</table>
					
		</form>
		
	</body>
</html>