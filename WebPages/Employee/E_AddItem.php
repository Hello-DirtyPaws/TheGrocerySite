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
    $name = $_POST['name'];
    $price = $_POST['price'];
    $count = $_POST['count'];
    $category = $_POST['category'];
    
    if(empty($name) || empty($price) || empty($count) || empty($category))
    {
        include('E_AddItem.php');
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
        
        $sql = "INSERT INTO Items (price, count, Name, category) VALUES ($price, $count, '$name', 
                (SELECT Category FROM Category WHERE Category='$category'))";
        
        $result = $conn->query($sql);
        if($result != null && $result)
        {
            include("./E_EmployeeInventoryPage.php");
            echo "<h3 align='center' style='color:green'>New Item added successfully.</h3>";
            exit;
        }
        else
        {
            include('E_AddItem.php');
            echo "<h3 align='center' style='color:red'>Item with that name already exist or the categroy is deleted. Please, try Again.</h3>";
            exit;
        }
    }
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
        
    $sql = "SELECT category FROM Category";
    $result = $conn->query($sql);
    $categories = array();
    
    if($result != null && $result)
    {
        while($row = $result->fetch_assoc())
        {
            array_push($categories, $row['category']);
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
	<body class="employeeBody">
	    
	    <?php include('EmployeeNavigationBar.php'); ?>
    
        <h1 align="center">Logged in to the Grocery Store as Employee</h1>
        <h2 align="center">Add Item<br></h2>
        
        <form method="post" action="E_AddItem.php">
    		<table class='table'>
    		    <tr>
    		        <td>Itme Name</td> <td> <input type="text" name="name"> </td>
    		    </tr>
    		    <tr>
    		        <td>Category</td> 
    		        <td> 
    		            <select name='category' style="font-size:17px;">
                        <?php
                            foreach($categories as $category)
                            {
                                echo "<option value='$category'>$category</option>";
                            }
                        ?>
                        </select>
    		        </td>
    		    </tr>
    		    <tr>
    		        <td>Unit Price</td> <td> <input type=number min=0.01 step=0.01 name="price"> </td>
    		    </tr>
    		    <tr>
    		        <td>Count</td> <td> <input type=number min=1 name="count"></td>
    		    </tr>
    		    <tr>
        		    <td><button style="font-size:20px;" type="submit" name="submit">Add</button></td>
        		    <td>
        		        <button style="font-size:20px;" onclick="javascript: window.location.href = 'E_EmployeeInventoryPage.php'; return false;">cancel</button>
        		    </td>
    		    </tr>
    		</table>
    	</form>
	</body>
</html>