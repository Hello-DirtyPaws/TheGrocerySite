<?php
session_start();
if($_SESSION["role"] != "Admin" && $_SESSION["role"] != "Manager" && $_SESSION["role"] != "Employee")
{
    header('HTTP/1.0 404 Unauthorized');
    exit;
}
if(isset($_POST['submit']))
{
    unset($_POST['submit']);
    $new_category_to_add = trim($_POST['new_category_to_add']);
    
    if(!empty($new_category_to_add))
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
        
        $sql = "INSERT INTO Category (Category) VALUES ('$new_category_to_add')";
        $result = $conn->query($sql);
        
        if($result != null && $result)
        {
            $msg = "New Category added successfully!";
        }
        else
        {
            $msg = "Category already exist.";  
        }
    }
    else
    {
        $msg = "Error! Invalid category name passed!";
    }
}
else
{
    $msg = null;
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
        <h2 align="center">All Active Categories<br></h2>
        
        <form method='post' action='E_ManageCategories.php' align='center'>
            <table class='table'>
                <tr>
                    <td>
                        <input style='font-size:20px;' type='text' name='new_category_to_add' placeholder='Category Name'>
                    </td>
                    <td>
                        <button style='font-size:20px;' type='submit' name='submit'>(+)Add Category</button>
                    </td>
                </tr>
            </table>
        </form>
        
        <h4 align='center'><?php echo $msg; ?></h4>
        
    	
    	<?php
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

            $sql = "Select Category from Category";
            $result = $conn->query($sql);
            
            //table begins
            echo "<table class='listDispayTable'>";
            echo "<tr> <th>S.No</th><th>Category</th>
                       <th>edit</th><th>delete</th>
                </tr>";
            if($result != null && $result)
            {
                $i=1;
                while($row = $result->fetch_assoc())
                {
                    $category = $row['Category'];
                    echo "<tr>
                              <td>$i</td><td>".$category."</td>
                              <td><a href='E_EditCategory.php?category=$category'>Edit</a></td>
                              <td><a href='E_DeleteCategory.php?category=$category'>Delete</a></td>
                          </tr>";
                    $i++;
                }
            }
            else
            {
                //No Categories   
            }
            
            //table ends
            echo "</table>";
        ?>
		
	</body>
</html>