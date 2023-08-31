<?php

    include("path.php");
    include(ROOT_PATH.'/app/controllers/requisition.php');
    include(ROOT_PATH.'/app/helpers/middleware.php');
    usersOnly();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width ,initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
  

    <!--Font Awesome csss link-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css" />

    <!--Sleek carousel-->
    <link type="text/css" rel="stylesheet" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">


    <!--The css link-->
    <link rel="stylesheet" href="assets/css/styles.css" type="text/css" />
    <link rel="stylesheet" href="assets/css/errors.css" />
    
    
       <!--Boostrap cdn css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!--//Boostrap cdn css-->

    <!--Google fonts -->
    <script href="https://kit.fontawesome.com/95dc93da07.js"></script>

    <!--Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Candal&display=swap" rel="stylesheet">

     <link href="https://fonts.googleapis.com/css2?family=Candal&display=swap" rel="stylesheet">

    <!--JQuery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous"></script>

    <!--Sleek carousel-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <link type="text/css" rel="stylesheet" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
     <script src="assets/js/index.js"></script>


    <title>Total.Security</title>
</head>
    
<body class="bg-info">
   <header>
            <div class="flex container">
                <a id="logo" href="#"><span>TotalSecurity.</span>Inventory</a>

                <nav>
                    <button id="nav-toggle" class="hamburger-menu">
                        <span class="strip"></span>
                        <span class="strip"></span>
                        <span class="strip"></span>
                    </button>


                    <ul id="nav-menu" class="ls-sticky">
                        <li> <a href="index.php" class="active">Home</a></li>
                        <li> <a href="https://totalsecuritykenya.com/">Main Site</a></li>
                     
                        <?php if(isset($_SESSION['id'])): ?>
                        <li> <a class="logout" href="<?php echo  BASE_URL." /logout.php" ?>">Logout</a></li>
                        <?php endif; ?>

                        <li id="close-flyout"><span class="fas fa-times"></span></li>

                    </ul>
                </nav>
            </div>

        </header>

       
<?php

 if ($_SERVER["REQUEST_METHOD"] === "POST") 
 {
    // Get the submitted item and quantity arrays
     if(!empty($_FILES['document']['name']))
	{
		$file_name=time().'_'.$_FILES['document']['name'];
        $destination=ROOT_PATH."/assets/files/".$file_name;

        $result=move_uploaded_file($_FILES['document']['tmp_name'],$destination);
        $_POST['document']=$file_name;
	}

    $items = $_POST['item'];
    $quantities = $_POST['quantity'];

     if (empty($_POST['item'])) {
        echo '<div class="alert alert-danger" role="alert">
                Item cannot be empty
            </div>';
    }

    
    if(empty($_POST['reason']))
    {
        echo '<div class="alert alert-danger" role="alert">
            Reason cannot be empty
        </div>';
    }
    
   $table ='requisition';

   $reason = $_POST['reason'];
   $user_id = $_POST['user_id'];
   $orderedBy =$_POST['orderdBy'];
   $department =$_POST['department'];

   if(empty($items))
   {
       
        header('location:'.BASE_URL."/redirect.php");
        exit();
   }
    
    function randomPassword()
    {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 3; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    // Iterate over the submitted arrays
    for ($i = 0; $i < count($items); $i++) 
    {
        $item = $items[$i];
        $quantity = $quantities[$i];
        $item_id=  getItem_id($item);
        $remainingInStore = findRemaining($item);
        $remainingInStoreAterOrder=findRemainingAfterOrder($item);


        $sum= getTotalQuantityOrdered($item);
        $total = getTotalInventory($item);
        $remainingInStore = findRemaining($item);
        $ordered= $quantity;

   

        // Concatenate the first two letters of the item with the quantity
         $orderId = findmaxId()+1;
         $deptName = substr($department,0,2);
         $finalId = substr($item, 0, 2) . $quantity.$deptName.$orderId.randomPassword();
         $finalId=strtoupper($finalId);
        

    

        if (!empty($quantity)) {
            $validQuantities[] = $quantity; // Add the valid quantity to the array
        } 
       
        $remaining = $total-$sum;

        if($remainingInStoreAterOrder == 0)
        {
            $remainingAfterOrder=$remainingInStore-floatval($quantity);
            $_POST['remainingAfterOrder']=  $remainingAfterOrder;
        }

        if($remainingInStoreAterOrder<=1000000000 )
        {
            $remainingAfterOrder=($total-(($sum)+floatval($quantity)));
            $_POST['remainingAfterOrder'] = $remainingAfterOrder;

        }

        elseif($remainingInStoreAterOrder ==1)
        {
            $remainingAfterOrder=($total-(($sum)+floatval($quantity)));
            $_POST['remainingAfterOrder'] = $remainingAfterOrder;

        }

        else 

        {
            $remainingInStoreAterOrder=findRemainingAfterOrder($item);
            $remainingAfterOrder=$remainingInStoreAterOrder - floatval($quantity);
            $_POST['remainingAfterOrder']= $remainingAfterOrder;

        }
      
        // Perform any necessary data validation or sanitization here
        // Insert the values into the database or perform any other desired action

        $item_ids[] = $item_id;
        $quantityNo[]= $quantity;
        $ids[] = $remainingAfterOrder;
        $final[] = $finalId; 


     
    
    }


    $_POST['item_id'] = $item_ids;
    $_POST['remainingAfterOrder']=$ids;
    $_POST['quantity']=$quantityNo;
    $_POST['reason'] = array_fill(0, count($items), $reason);
    $_POST['user_id'] = array_fill(0, count($items), $user_id);
    $_POST['orderdBy'] = array_fill(0, count($items), $orderedBy);
    $_POST['department'] = array_fill(0, count($items), $department);
    // Add $_POST['finalId'] to the $_POST array
    $_POST['finalId'] = $final;



  

function insertDataIntoRequisition($data)
{
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbName = "inventory";

    $conn = new mysqli($host, $user, $password, $dbName);

    if ($conn->error) {
        die("Database connection error" . $conn->connect_error);
    }

    // Prepare the SQL statement
    $sql = "INSERT INTO requisition (item, quantity, item_id, user_id, orderdBy, remainingAfterOrder, department, reason, finalId, document) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    // Prepare the statement
    $stmt = $conn->prepare($sql);

    // Bind parameters and execute the statement for each array item
    foreach ($data['item'] as $key => $item)
    {
        $quantity = $data['quantity'][$key];
        $item_id = $data['item_id'][$key];
        $user_id = $data['user_id'][$key];
        $orderedBy = $data['orderdBy'][$key];
        $remainingAfterOrder = $data['remainingAfterOrder'][$key];
        $department = $data['department'][$key];
        $reason = $data['reason'][$key];
        $finalId =$data['finalId'][$key];
        $document=$data['document'];

        // Bind parameters to the statement
        $stmt->bind_param("siiisissss", $item, $quantity, $item_id, $user_id, $orderedBy, $remainingAfterOrder, $department, $reason, $finalId, $document);

        // Execute the statement
        $stmt->execute();
    }

    // Close the statement and the database connection
    $stmt->close();
    $conn->close();
}


    $itemArray = $_POST['item'];
    $quantityarray =$_POST['quantity'];
    $itemCount = array_count_values($itemArray);

    foreach ($itemCount as $item => $count) {
        if ($count > 1) {
            echo '<div class="alert alert-danger" role="alert">
                    You chose an item  more than once
                </div>';
            // You can also display an alert using JavaScript: echo "<script>alert('Error: Item $item is chosen multiple times.');</script>";
            // You may want to break the loop or take appropriate action based on your requirements.
        }
    }

    $quantityArray = $_POST['quantity'];

    foreach ($quantityArray as $quantity) {
        if (empty($quantity)) {
            echo '<div class="alert alert-danger" role="alert">
                  Quantity cannot be empty
                </div>';
        }
    }

  


   $errors = []; // Initialize an array to store error messages

    if (empty($_POST['item']))
    {
        $errors[] = "Item is null!";
    } 

     //checkk if reason is empty

    elseif(empty($_POST['reason']))
    {
        $errors[] = "Reason cannot be empty";
    }

    //...
    
    
    else
    {
        // ...

        // Check for duplicate items
        foreach ($itemCount as $item => $count)
        {
            if ($count > 1) {
                $errors[] = "You chose item '$item' more than once";
                // You can also add the error message to the $errors array using the following format:
                // $errors[] = "Error: Item '$item' is chosen multiple times.";
                // You may want to break the loop or take appropriate action based on your requirements.
            }
        }


        $reasonArray = $_POST['reason'];
          foreach ($reasonArray as $reason)
        {
            if (empty($reason)) {
                $errors[] = "Reason is Empty";
                // You can also add the error message to the $errors array using the following format:
                // $errors[] = "Error: Item '$item' is chosen multiple times.";
                // You may want to break the loop or take appropriate action based on your requirements.
            }
        }

       

        // Check for empty quantities
        $quantityArray = $_POST['quantity'];

        foreach ($quantityArray as $quantity) {
            if (empty($quantity)) {
                $errors[] = "Quantity cannot be empty";
            }
        }

        // ...
    }

    // Check if any errors occurred
    if (count($errors) > 0) 
    {
        echo '<div class="alert alert-danger" role="alert">
                  Error occurred: ';
        foreach ($errors as $error) 
        {
            echo $error . '<br>';
        }
        echo '</div>';
    } else

    {
        echo '<div class="alert alert-success" role="alert">
                  No errors occurred!
                </div>';
        
        $remainingAfterOrders=$ids;
        
   
             
        if (min($remainingAfterOrders)>= 0)
        {
            
            insertDataIntoRequisition($_POST);
            $_SESSION['message']="4";
            header('location:'.BASE_URL."/redirect.php");
            exit();
        }
        else 
        {
            $_SESSION['message']="5";
            header('location:'.BASE_URL."/redirect.php");
            exit();
	
        }


               

        
           
      }




 }
    


?>


   <div class="d-inline-flex p-5 m-3 bg-white w-100 h-100 ">
   

    <form id="sendform" method="post" action="#"   class="m-5" enctype=multipart/form-data > 
     <h1 class="text-dark" >Request Inventory</h1>
        <input type="hidden" id="subject" name="user_id" value="<?php echo $_SESSION['id'] ?>" />
        <input type="hidden" id="subject" name="orderdBy" value="<?php echo $_SESSION['username']. ' ' . $_SESSION['secondname']; ?>" />
        <input type="hidden" id="subject" name="remainingAfterOrder" value="<?php echo $remainingAfterOrder ?>" />
        <input type="hidden" id="subject" name="department" value="<?php echo $_SESSION['department'] ?>" />

    <div id="fieldsetContainer" >
     <button type="button" class="btn btn-warning m-1"  onclick="addFieldset()">Add Field</button>

      <fieldset class="form-group">
        <select name="item[]" id="items"  class="p-1 block w-10 h-10 " >
          <option value="" selected disabled hidden>Choose here</option>
          <?php foreach ($items as $key => $item): ?>
            <?php if (!empty($item_id) && $item_id == $item['id']): ?>
              <option selected value="<?php echo $item['item'];?>"><?php echo $item['item']; ?></option>
            <?php else: ?>
              <option value="<?php echo $item['item']; ?>"><?php echo $item['item']; ?></option>
            <?php endif; ?>
          <?php endforeach; ?>
        </select>
        <input type="number" id="fullname" name="quantity[]" min="1" max="100" placeholder="No"   class="p-1 m-1 block w-20 h-10 " />
      </fieldset>

    </div>

    
    <label for="message">Reason</label>
    <textarea id="message" name="reason"  class="form-control" id="exampleFormControlTextarea1" rows="3" ><?php echo $reason ?></textarea>
    <br>
    <label for="file">Select a Supporting Document</label>
    <br>
    <input type="file" name="document" id="message">
    

    <br>

  <input type="submit" value="Request" class="btn btn-info mt-1"  />
</form>
</div>

 <script src="assets/js/index.js"></script>
 <script>
      function addFieldset() {
        // Get the container element
        var container = document.getElementById("fieldsetContainer");

        // Clone the last fieldset
        var lastFieldset = container.lastElementChild.cloneNode(true);

        // Reset the cloned fieldset values
        var clonedSelect = lastFieldset.querySelector("select");
        clonedSelect.selectedIndex = 0;
        var clonedInput = lastFieldset.querySelector("input");
        clonedInput.value = "";

        // Add the cloned fieldset to the container
        container.appendChild(lastFieldset);
      }
    </script>

<!--Boostrap cdn js-->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
<!--Boostrap cdn js-->
   

</body>


</html>