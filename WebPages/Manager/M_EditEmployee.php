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
    $id = $_GET['id'];
    $name = $_POST['name'];
    $email = strtolower($_POST['email']);
    $phone = $_POST['phone'];
    
    if(empty($name) || empty($email) || empty($phone))
    {
        include('M_EditEmployee.php');
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
        
        $sql = "UPDATE Users 
                SET 
                    name = '$name',
                    email = '$email',
                    phone = '$phone'
                WHERE
                    id = $id";
    
        $result = $conn->query($sql);
        if($result != null && $result)
        {
            $id_d = $id;
            include('M_ManagerEmployeePage.php');
            echo "<h3 align='center' style='color:green'>Manager(ID:$id_d) details changed successfully.</h3>";
            exit;
        }
        else
        {
            include('M_ManagerEmployeePage.php');
            echo "<h3 align='center' style='color:red'>User with that Email already exist. Please, try Again.</h3>";
            exit;
        }
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
        include('A_AdminManagerPage.php');
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
		    <table class='table'>
		        <tr>
		            <td>Employee ID: </td> <td><?php echo $id; ?></td>
		        </tr>
		        <tr>
		            <td>Name: </td> <td><input type=text name='name' value=<?php echo $name ?> /></td>
		        </tr>
		        <tr>
		            <td>Phone: </td>
		            <td><input required type='tel' pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" name='phone' value=<?php echo $phone ?> /></td>
		        </tr>
		        <tr>
		            <td>Email: </td> <td><input type=text name='email' value=<?php echo $email ?> /></td>
		        </tr>
		        <tr>
    			    <td><input type="submit" name="submit" value="Save"></td>
    			    <td><input type="button" value="cancel" onclick="window.location.href = './M_ManagerEmployeePage.php';"> </td>
			    </tr>
		    </table>
		 </form>
		
	</body>
</html>