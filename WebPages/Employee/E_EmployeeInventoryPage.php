<?php
session_start();
if($_SESSION["role"] != "Employee")
{
    header('HTTP/1.0 404 Unauthorized');
    exit;
}

//Get all different categories to display
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

//check if search was pressed
if(isset($_POST['search']) && !empty($_POST['searchToken']))
{
    unset($_POST['search']);
    $_SESSION["searchToken"] = $_POST['searchToken'];
}
else
{
    if(isset($_SESSION['searchToken']))
    {
        unset($_SESSION['searchToken']);
    }
    
    //check if category option was selected
    if(isset($_POST['displayCategory']))
    {
        $_SESSION['categoryToken'] = $_POST['category'];
        unset($_POST['displayCategory']);
        unset($_POST['category']);
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

    <h1 align="center">The Grocery Store</h1>
    <h2 align="center">Current Inventory<br></h2>
    
    <table style="width:100%;">
        <tr>
            <td>
                <!-- Add Item -->
                <form method='post' action='E_AddItem.php'>
                    <button style="font-size:23px; background-color:#bfbabe;" type="submit">(+)Add Item</button>
                </form>
            </td>
            <td>
                <!-- Category chooser -->
                <form method='post' action='E_EmployeeInventoryPage.php'>
                    <table class='table'>
                        <tr>
                            <td><strong style="font-size:20px;">Select Category: </strong></td>
                            <td>
                                <select name='category' style="font-size:20px;">
                                    <option value='All'>Show All</option>
                                    <?php
                                    foreach($categories as $category)
                                    {
                                        echo "<option value='$category'>$category</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td><button style="font-size:20px; background-color:#bfbabe;" type='submit' name='displayCategory'>display</button></td>
                        </tr>
                    </table>
                </form>
            </td>
            <td>
                <!-- Search -->
                <form align='right' method='post' action='E_EmployeeInventoryPage.php'>
                    <input style="font-size:20px;" type="text" placeholder="Search Item Name..." name="searchToken">
                    <button style="font-size:20px; background-color:#bfbabe;" type="submit" name='search'>Search</button>
                </form>
            </td>
        </tr>
    </table>

	<?php include('E_InventoryListDisplay.php'); ?>
	
	<h4 align='center'>x---End of list---x</h4>

	</body>
</html>