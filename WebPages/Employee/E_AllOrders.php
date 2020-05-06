<?php
session_start();
if($_SESSION["role"] != "Admin" && $_SESSION["role"] != "Manager" && $_SESSION["role"] != "Employee")
{
    header('HTTP/1.0 404 Unauthorized');
    exit;
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

    	<h1 align='center'>The Grocery Store</h1>
        <h4 align='center'>Order History</h4>

        <table class='listDispayTable'>
        <tr><th>S.No</th><th>Order ID</th><th>User ID</th>
        <th>Date</th><th>Order Total</th><th>View Details</th> 
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
            
            
            $sql = "Select Order_Id, Date, User_Id, Total from Orders ORDER BY Order_Id DESC";
            
            $result = $conn->query($sql);
            
            if($result != null && $result)
            {
                $i=1;
                while($row = $result->fetch_assoc())
                {
                    $orderId = $row['Order_Id'];
                    $date = $row['Date'];
                    $total = $row['Total'];
                    $userId = $row['User_Id'];
                    
        ?>  
                    <form method='post' action='E_OrderDetails.php'>
                        <input type='hidden' name='orderId' value=<?php echo $orderId; ?>>
                        <input type='hidden' name='total' value=<?php echo $total; ?>>
                        <tr>
                            <td><?php echo $i; ?></td><td><?php echo $orderId; ?></td><td><?php echo $userId; ?></td>
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