<?php
session_start();
if($_SESSION["role"] != "Customer")
{
    header('HTTP/1.0 404 Unauthorized');
    exit;
}

$searchToken = null; 

if(isset($_POST['orderPlaced']))
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
    
    $conn->autocommit(FALSE);
    {
        $userId = $_SESSION['id'];
        $total = $_POST['total'];
        
        $sql = "INSERT INTO Orders (User_ID, Total) VALUES ($userId, $total)";
        $result = $conn->query($sql);
        
        if($result != null && $result)
        {
            $DBorderID = $conn->insert_id;
            $sql = "INSERT INTO Items_Ordered (Item_ID, Item_Name, Item_Price, Item_Quantity, Order_ID)
                    SELECT 
                        C.Item_ID as Item_ID, I.Name as Item_Name, I.Price as Item_Price, 
                        C.Quantity as Item_Quantity,
                        (SELECT Order_ID FROM Orders WHERE Order_ID = $DBorderID)
                    FROM Cart as C, Items as I
                        WHERE User_ID = $userId
                        AND I.ID = C.Item_ID";
            $result = $conn->query($sql);
            
            if($result != null && $result)
            {
                $sql = "SELECT Item_ID, Quantity FROM Cart WHERE User_ID = $userId";
                
                $result = $conn->query($sql);
                if($result != null && $result)
                {
                    while($row = $result->fetch_assoc())
                    {
                        $itemId = $row['Item_ID'];
                        $quantityOrdered = $row['Quantity'];
                        
                        $sql = "SELECT count FROM Items WHERE ID = $itemId";
                        $result1 = $conn->query($sql);
                        
                        if($result1 != null && $result1)
                        {
                            $row1 = $result1->fetch_assoc();
                            if($row1['count'] >= $quantityOrdered)
                            {
                                $sql = "UPDATE Items SET count = count-$quantityOrdered WHERE ID = $itemId";
                                $result2 = $conn->query($sql);
                            }
                            else
                            {
                                $conn->rollback();
                                $sql = "DELETE FROM Cart WHERE Item_ID = $itemId AND User_ID = $userId";
                                $result = $conn->query($sql);
                                $conn->commit();
                                $conn->close();
                                
                                include('./C_CustomerCartPage.php');
                                echo "<h4 align='center'>Error! One item from your cart is
                                        removed because of change in availability of stock.</h4>";
                                exit;
                            }
                        }
                    }
                    $sql = "DELETE FROM Cart WHERE User_Id = $userId";
                    $result = $conn->query($sql);
                    $conn->commit();
                }
            }
            else
            {
                $conn->rollback();
            }
        }
        else
        {
            $conn->rollback();
        }
    }
    $conn->close();
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
        <h4 align='center'>Order History</h4>
        
        
        <table class='listDispayTable'>
        <tr>
            <th>S.No</th><th>Order ID</th><th>Date</th>
            <th>Order Total</th><th>View Details</th> 
        </tr>
        <?php
        //Display Orders List
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
            
            $userId = $_SESSION['id'];
            
            $sql = "SELECT Order_ID, Date, Total FROM Orders 
                    WHERE User_Id = $userId
                    ORDER BY Order_Id DESC";
            
            $result = $conn->query($sql);
            
            if($result != null && $result)
            {
                $i=1;
                while($row = $result->fetch_assoc())
                {
                    $orderId = $row['Order_ID'];
                    $date = $row['Date'];
                    $total = $row['Total'];
                    
        ?>  
                    <form method='post' action='C_OrderDetails.php'>
                        <input type='hidden' name='orderId' value=<?php echo $orderId; ?>>
                        <input type='hidden' name='total' value=<?php echo $total; ?>>
                        <tr>
                            <td><?php echo $i; ?></td><td><?php echo $orderId; ?></td>
                            <td><?php echo $date; ?></td><td>$<?php echo $total; ?></td>
                            <td><button type='submit' style='font-size:20px;'>View Details</button></td>
                        </tr>
                    </form>
        <?php       $i++;
                }
            }
            $conn->close();
        ?>    
            </table>
        <?php    
        }
        ?>
    	
    	<h4 align='center'>x---End of list---x</h4>
	</body>
</html>