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
    
    $old_category = trim($_POST['old_category']);
    $new_category = trim($_POST['new_category']);
    
    if(empty($new_category))
    {
        include('E_EditCategory.php');
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
        
        $sql = "UPDATE Category 
                SET
                    category = '$new_category'
                WHERE
                    category = '$old_category'";
                    
        $result = $conn->query($sql);
        if($result != null && $result)
        {
            include('E_ManageCategories.php');
            echo "<h3 align='center' style='color:green'>Category updated successfully.</h3>";
            exit;
        }
        else
        {
            include('E_ManageCategories.php');
            echo "<h3 align='center' style='color:red'>Category already exist. Please, try Again.</h3>";
            exit;
        }
    }
}
else 
{
    $old_category = trim($_GET['category']);
    if(empty($old_category))
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
        <h2 align="center">Edit Category<br></h2>
        
        <form method='post' action='E_EditCategory.php'>
            <input type='hidden'name='old_category' value='<?php echo $old_category; ?>'>
            <table class='table'>
                <tr>
                    <td><input style="font-size:20px" type='text' name='new_category' value='<?php echo $old_category; ?>'></td>
                </tr>
                <tr>
    			    <td><input style="font-size:20px" type="submit" name="submit" value="Save"></td>
    			    <td><input style="font-size:20px" type="button" value="cancel" onclick="window.location.href = './E_ManageCategories.php';"> </td>
    		    </tr>
            </table>
        </form>
				
	</body>
</html>