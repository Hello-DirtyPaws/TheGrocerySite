<?php
session_start();
if($_SESSION["role"] != "Manager" || empty($_GET['id']) || $_GET['id']<2)
{
    header('HTTP/1.0 404 Unauthorized');
    exit;
}

if (isset($_POST['submit'])) 
 {
    unset($_POST['submit']);
    $id = $_POST['id'];

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
    $sql = "DELETE FROM Users WHERE id = $id";

    $result = $conn->query($sql);
    if($result != null && $result)
    {
        $id_d = $id;
        include('M_ManagerEmployeePage.php');
        echo "<h3 align='center' style='color:green'>Employee(ID:$id_d) deleted successfully.</h3>";
        exit;
    }
    else
    {
        $id_d = $id;
        include('M_ManagerEmployeePage.php');
        echo "<h3 align='center' style='color:red'>Employee(ID:$id_d) does not exist. Please, try Again.</h3>";
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
    $sql = "SELECT Role, ID, Name, Phone, Email FROM Users WHERE id=$id";
    
    $result = $conn->query($sql);
    if($result != null && $result)
    {
        $row = $result->fetch_assoc();
        if($row['Role'] == 'Employee')
        {
            $id = $row['ID'];
            $name = $row['Name'];
            $email = $row['Email'];
            $phone = $row['Phone'];
        }
        else
        {
            $id_d = $id; 
            include('M_ManagerEmployeePage.php');
            echo "<h3 align='center' style='color:red'>No Employee with id: $id_d exist. Please, try Again.</h3>";
            exit;
        }
    }
    else
    {
        $id_d = $id;
        include('M_ManagerEmployeePage.php');
        echo "<h3 align='center' style='color:red'>No Employee with id: $id_d exist. Please, try Again.</h3>";
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
	<body class="managerBody">
	   
        <?php include('ManagerNavigationBar.php'); ?>

		<h1 align="center">Logged in to the Grocery Store</h1>
		<h2 align="center">Welcome Manager<br></h2>
		<form method='post' action=''>
		    <input type='hidden' name='id' value=<?php echo $id; ?>>
		    <table class='table'>
		        <tr>
		            <td>Employee ID: </td> <td><?php echo $id; ?></td>
		        </tr>
		        <tr>
		            <td>Name: </td> <td><?php echo $name ?></td>
		        </tr>
		        <tr>
		            <td>Phone: </td> <td><?php echo $phone ?></td>
		        </tr>
		        <tr>
		            <td>Email: </td> <td><?php echo $email ?></td>
		        </tr>
		        <tr>
    			    <td><input type="submit" name="submit" value="Confirm Delete"></td>
    			    <td><input type="button" value="cancel" onclick="window.location.href = './M_ManagerEmployeePage.php';"> </td>
			    </tr>
		    </table>
		 </form>
		
	</body>
</html>