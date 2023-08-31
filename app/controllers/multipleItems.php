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
     else {
        // If no file is uploaded, set the 'document' field to null or an empty value
        $_POST['document'] =""; // or $_POST['document'] = '';
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
        foreach ($errors as $error) {
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
