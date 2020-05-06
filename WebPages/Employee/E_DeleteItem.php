<?php
session_start();
if($_SESSION["role"] != "Employee")
{
    header('HTTP/1.0 404 Unauthorized');
    exit;
}

if (isset($_POST['submit'])) 
{
    unset($_POST['submit']);
    $id = trim($_POST['id']);
    
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
    
    $sql = "Delete from Items WHERE id = $id";

    $result = $conn->query($sql);
    if($result != null && $result)
    {
        $id_d = $id;
        include('E_EmployeeInventoryPage.php');
        echo "<h3 align='center' style='color:green'>Item(ID:$id_d) deleted successfully.</h3>";
        exit;
    }
    else
    {
        $id_d = $id;
        include('E_EmployeeInventoryPage.php');
        echo "<h3 align='center' style='color:red'>Item(ID:$id_d) does not exist.</h3>";
        exit;
    }
}
else 
{
    $id = $_GET['id'];
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
    
    $sql = "SELECT Category, ID, Name, Price, Count FROM Items WHERE id=$id";
    
    $result = $conn->query($sql);
    if($result != null && $result)
    {
        $row = $result->fetch_assoc();
        $id = $row['ID'];
        $name = $row['Name'];
        $count = $row['Count'];
        $price = $row['Price'];
        $category = $row['Category'];
    }
    else
    {
        $id_d = $id;
        include('E_EmployeeInventoryPage.php');
        echo "<h3 align='center' style='color:red'>No Item with id: $id_d exist. Please, try Again.</h3>";
        exit;
    }
}

?>
<html>
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" type="text/css" href="../CSS/stylesheet.css"/>
		<title>Grocery Store</title>
	</head>
	<body class="employeeBody">
	   
    <?php include('EmployeeNavigationBar.php'); ?>

	<h1 align="center">Logged in to the Grocery Store</h1>
	<h2 align="center">Welcome Employee<br></h2>
	<form method='post' action=''>
	    <input type='hidden' name='id' value=<?php echo $id; ?>>
	    <table class='table'>
	        <tr>
	            <td>Item ID: </td> <td><?php echo $id; ?></td>
	        </tr>
	        <tr>
	            <td>Name: </td> <td><?php echo $name; ?></td>
	        </tr>
	        <tr>
	            <td>Category: </td> <td><?php echo $category; ?></td>
	        </tr>
	        <tr>
	            <td>Price: </td> <td>$<?php echo $price; ?></td>
	        </tr>
	        <tr>
	            <td>Count: </td> <td><?php echo $count; ?></td>
	        </tr>
	        <tr>
			    <td><input type="submit" name="submit" value="Confirm Delete"></td>
			    <td><input type="button" value="cancel" onclick="window.location.href = './E_EmployeeInventoryPage.php';"> </td>
		    </tr>
	    </table>
	 </form>
		
	</body>
</html>