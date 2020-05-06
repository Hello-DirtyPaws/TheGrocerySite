<?php
session_start();
if($_SESSION["role"] != "Customer")
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
    
    if(isset($_SESSION['categoryToken']))
    {
        unset($_SESSION['categoryToken']);
    }
}

//check if category option was selected
else if(isset($_POST['displayCategory']))
{
    $_SESSION['categoryToken'] = $_POST['category'];
    unset($_POST['displayCategory']);
    unset($_POST['category']);
    
    if(isset($_SESSION['searchToken']))
    {
        unset($_SESSION['searchToken']);
    }
}
//else check if addToCart was pressed for an item
else
{
    if(isset($_POST['addToCart']))
    {
        unset($_POST['addToCart']);
        $userId = $_SESSION['id'];
        $itemId = $_POST['itemId'];
        $quantity = $_POST['quantity'];
        
        $sql = "INSERT INTO Cart (User_ID, Item_ID, Quantity) values (
                                (SELECT ID FROM Users WHERE ID=$userId),
                                (SELECT ID FROM Items WHERE ID=$itemId), $quantity)";
                                
        $result = $conn->query($sql);
        if($result == null || !$result)
        {
            $sql = "UPDATE Cart 
                    SET
                        QUANTITY = QUANTITY+$quantity
                    WHERE
                        User_ID = (SELECT ID FROM Users WHERE ID=$userId)
                        AND
                        Item_ID = (SELECT ID FROM Items WHERE ID=$itemId)";
        
            $result = $conn->query($sql);
            if($result == null || !$result)
            {
                $msg = "Please check the item quantity in your cart!";
            }
            else
            {
                $msg = "Item added to the Cart successfully.";
            }
        }
        else
        {
            $msg = "Item added to the Cart successfully.";
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
	<body class="customerBody">
	    
        <?php include('C_CustomerNavigationBar.php'); ?>
        
        <h2 align='center'>The Grocery Store</h2>
        <h4 align='center'>The Shopping Area</h4>
        
        <!-- Category chooser/Search/Check out-->
        <table style="width:100%;">
            <tr>
                <!-- Category chooser -->
                <td align='left'>
                    <form method='post' action='C_CustomerShopPage.php'>
                        <table class='table'>
                            <tr>
                                <td><strong style="font-size:20px;">Select Category: </strong></td>
                                <td>
                                    <select name='category' style="font-size:20px;">
                                        <option value='All'> </option>
                                        <option value='All'>All</option>
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
                
                <!-- Search -->
                <td align='center'>
                    <form method='post' action='C_CustomerShopPage.php'>
                        <input style="font-size:20px;" type="text" placeholder="Search Item Name..." name="searchToken">
                        <button style="font-size:20px; background-color:#bfbabe;" type="submit" name='search'>Search</button>
                    </form>
                </td>
                
                <!-- Check out button -->
                <td align='right'>
                    <form method='post' action='C_CustomerCartPage.php'> 
                        <button style="border-radius:40px; font-size:25px; background-color:#bfbabe;" type="submit">Your Cart</button>
                    </form>
                </td>
            </tr>
         </table>
         
         <h3 align='center'><?php echo $msg; ?></h3>
        
        <?php include('C_InventoryItemsList.php'); ?>
    	
    	
    	<h4 align='center'>x---End of list---x</h4>
	</body>
</html>