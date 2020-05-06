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
    
    $category = trim($_POST['category']);
    
    if(empty($category))
    {
        include('E_ManageCategories.php');
        echo "<h3 align='center' style='color:red'>Unknown Category!!. Please, try again.</h3>";
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
        
        $sql = "DELETE FROM Category WHERE category = '$category'";
                    
        $result = $conn->query($sql);
        if($result != null && $result)
        {
            include('E_ManageCategories.php');
            echo "<h3 align='center' style='color:green'>Category deleted successfully.</h3>";
            exit;
        }
        else
        {
            include('E_ManageCategories.php');
            echo "<h3 align='center' style='color:red'>Category does not exist. Please, try Again.</h3>";
            exit;
        }
    }
}
else 
{
    $category = trim($_GET['category']);
    if(empty($category))
    {
        include('E_ManageCategories.php');
        echo "<h3 align='center' style='color:red'>No Category selected. Please, try Again.</h3>";
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
        <h2 align="center">Delete Category<br></h2>
        
        <form method='post' action='E_DeleteCategory.php'>
            <input type='hidden'name='category' value='<?php echo $category; ?>'>
            <table class='table'>
                <tr aling='center'>
                    <td colspan='2' align='center'><h3 style='background-color:red' align='center'><?php echo $category; ?></h3></td>
                </tr>
                <tr>
    			    <td><input style="font-size:20px" type="submit" name="submit" value="Confirm Delete"></td>
    			    <td><input style="font-size:20px" type="button" value="cancel" onclick="window.location.href = './E_ManageCategories.php';"> </td>
    		    </tr>
            </table>
        </form>
        
				
	</body>
</html>