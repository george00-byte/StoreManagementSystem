<?php 
  
   include(ROOT_PATH.'/app/database/db.php');
   include(ROOT_PATH.'/app/helpers/validateRequisition.php');

  

   $table ='requisition';

   $tableMessage = 'messages';

   $tableStore='store';

   $tableDepartment='department';

  

   $requisitions=selectAll($table);
   $requisitionsDesc=selectAllDesc($table);
   $requisitionsPending= selectAllPending($table);

   $items=selectAll($tableStore);


   $departments=selectAll($tableDepartment);

   $id= $_SESSION['id'];
   $uniqueOrders=getUniqueOrders($id);

   $dept=$_SESSION['department'];
   $requisitionInDept=selectAllInDepartment($dept);
   $requisitionInDeptDesc=selectAllInDepartmentDesc($dept);
   $requisitionInDeptPending=selectAllInDepartmentPending($dept);



   $messages=selectOne($tableMessage,['id'=>$id]);

  

   $errors=array();

   $id="";
   $item ='';
   $declineReason=""; 
   $decline="";
   $total ='';
   $quantity = '';
   $remaining="";
   $department = '';
   $item_id="";
   $reason="";
   $issue="";
   $approved="";
   $add="";
   $read="";
   $remainingAfterOrder="";



   
   if(isset($_POST["book_inventory"]))
   {
        if(!empty($_FILES['document']['name']))
	    {
		    $file_name=time().'_'.$_FILES['document']['name'];
            $destination=ROOT_PATH."/assets/files/".$file_name;

            $result=move_uploaded_file($_FILES['document']['tmp_name'],$destination);
            $_POST['document']=$file_name;
		
	    }
        $_POST['document']=$file_name;
        $errors = validateRequisition($_POST);

       if(count($errors) == 0)
       {
            $sum= getTotalQuantityOrdered($_POST['item']);
            $total = getTotalInventory($_POST['item']);
            $remainingInStore = findRemaining($_POST['item']);
            $ordered= $_POST['quantity'];
       
            $remaining = $total-$sum;
        
            $remainingInStoreAterOrder=findRemainingAfterOrder($_POST['item']);
            if($remainingInStoreAterOrder == 0)
            {
              $remainingAfterOrder=$remainingInStore-$_POST['quantity'];
              $_POST['remainingAfterOrder']=  $remainingAfterOrder;
            }

            if($remainingInStoreAterOrder<=1000000000 )
            {
              $remainingAfterOrder=($total-($sum+$_POST['quantity']));
              $_POST['remainingAfterOrder'] = $remainingAfterOrder;

            }

             elseif($remainingInStoreAterOrder ==1)
            {
              $remainingAfterOrder=($total-($sum+$_POST['quantity']));
              $_POST['remainingAfterOrder'] = $remainingAfterOrder;

            }


            else 

            {
              $remainingInStoreAterOrder=findRemainingAfterOrder($_POST['item']);
              $remainingAfterOrder=$remainingInStoreAterOrder - $_POST['quantity'];
              $_POST['remainingAfterOrder']= $remainingAfterOrder;

            }

        
            $item_id= getItem_id($_POST['item']);
            $_POST['item_id']= $item_id;

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

          
          

            if($remainingAfterOrder >= 0)
            {
                 if($total >0 && $sum<=$total && ($ordered <= $remainingInStore ))
                {
                    if(count($errors) === 0)
                    {
                        //give each iten a unique id
                        $itemName = substr($_POST['item'],0,2);
                        $deptName = substr($_POST['department'],0,2);
                        $orderId = findmaxId()+1;
                        $itemNo = $_POST['quantity'];
                        $uniqueId=strtoupper($itemName.$itemNo.$deptName.$orderId.randomPassword());

                    

                        //the unique id
                        $_POST['finalId']=$uniqueId;

                        $_POST['reason']=htmlentities($_POST['reason']);
                        unset($_POST["book_inventory"]); 
                        $req_id=create($table,$_POST);
           
                        $_SESSION['message']="4";
                        header('location:'.BASE_URL."/redirect.php");
                    }
                    else 
                    {
           
                       $quantity = $_POST['quantity'];
                       $department = $_POST['department'];
                       $reason =$_POST['reason'];
                    }

                }
                else
                 {
            
                    $_SESSION['message']="5";
                    header('location:'.BASE_URL."/redirect.php");
                    exit();
                }

            }
           else 
            {
            
                $_SESSION['message']="5";
                header('location:'.BASE_URL."/redirect.php");
                exit();

            }
       }


              
        
   }



if(isset($_GET['id']))
{
        
    $requisition=selectOne($table,['id'=> $_GET['id']]);

    $id=$requisition['id'];
    $item=$requisition['item'];
    $quantity=$requisition['quantity'];
    $department= $requisition['department'];
    $approve= $requisition['approve'];
    $issue=$requisition['issue'];
    $reason=$requisition['reason'];
    $approved=$requisition['approve'];
    $item_id=$requisition['item_id'];
    $decline=$requisition['decline'];
    $declineReason=$requisition['declineReason'];
    $uniqueId=$requisition['finalId'];
    $orderdBy=$requisition['orderdBy'];
    $issuedBy=$requisition['issuedBy'];
    $approvedBy=$requisition['approvedBy'];
    $created_at=date('Y-m-d', strtotime($requisition['created_at']));
    


   
}








if(isset($_POST['approve-inventory']))
{
      $sum= getTotalQuantityOrder($_POST['item']);
      $total = getTotalInventory($_POST['item']);
      $remainingInStore = findRemaining($_POST['item']);
     

      $remaining = $total - $sum;
     if($_POST['decline']==0 && $_POST['issue']==0 )
    {
          if($total >0 && $sum<=$total )
        {
            $id=$_POST['id'];
            //$_POST['approve']=isset($_POST['approve'])?1:0;

            $_POST['approve']=1;

            unset($_POST['approve-inventory'],$_POST['id']);

            $count = update($table,$id,$_POST);
             $_SESSION['type']="succes";
            $_SESSION['message']="Done";
            header('location: '.BASE_URL."/Admin/inventory/index.php");
            exit();
        }
        else 
        {
            $_SESSION['type']="error";
            $_SESSION['message']="Add Inventory in Store";
            header('location:'.BASE_URL."/Admin/inventory/index.php");
            exit();

        }

    }
    else 
    {
	    $_SESSION['type']="error";
        $_SESSION['message']="Inventory Declined/ Issued. ";
        header('location:'.BASE_URL."/Admin/inventory/index.php");
        exit();
    }

   
}




if(isset($_POST['decline-inventory']))
{
    $errors = validateDecline($_POST);

    if($_POST['approve']==0)
    {
        if(count($errors) === 0)
        {
            $id=$_POST['id'];
            //$_POST['decline']=isset($_POST['decline'])?1:0;
            $_POST['decline']=1;
            unset($_POST['decline-inventory'],$_POST['id']);
            $count = update($table,$id,$_POST);
            header('location: '.BASE_URL."/Admin/inventory/index.php");
            exit();
        }
        else 
         {

           $declineReason = $_POST['declineReason'];
           $quantity = $_POST['quantity'];
           $department = $_POST['department'];
           $item= $_POST['item'];

        }
    }
     else 
    {
	    $_SESSION['type']="error";
        $_SESSION['message']="Inventory Approved. unapprove First";
        header('location:'.BASE_URL."/Admin/inventory/index.php");
        exit();
    }

}



if (isset($_POST['message-User']))
{   
    $id=$_POST['id'];
    $_POST['issue']=isset($_POST['issue'])?1:0;
    $_POST['message'] = "Order Issued Come pick at store";
    $_POST['user_id'] = getUser_id($id);
    $_POST['quantity']=$_POST['quantity'];

    $notification = array(
    'message' => $_POST['message'],
    'user_id' => $_POST['user_id'],
    'item'=>$_POST['item'],
    'quantity'=>$_POST['quantity'],
    );

    
 
    $req_id=create($tableMessage,$notification);

    $_SESSION['type']="succes";   
    $_SESSION['message']="Message sent";
    header('location:'.BASE_URL."/Admin/store/index.php");
    exit();
}




 if(isset($_POST['issue-inventory']))
{
    $id=$_POST['id'];
    $_POST['approve']=isset($_POST['approve'])?0:1;
    $_POST['issue']=1;
    $_POST['approve']==1;

    $sum= getTotalQuantityOrder($_POST['item']);
    $total = getTotalInventory($_POST['item']);
    $remainingInStore = findRemaining($_POST['item']);

    

   
    if($total >0 && $sum<=$total)
    {

        if($_POST['issue']==1)
        {
            $remaining = $total - $sum;
            $_POST['remaining']=$remaining;

            $_POST['id']=$_POST['item_id'];
            unset($_POST['issue-inventory'],$_POST['user_id'],$_POST['id'],$_POST['quantity'],$_POST['department'],$_POST['date'],$_POST['reason'],$_POST['approve'],$_POST['item']);
            $count = update($table,$id,$_POST);
            $id = $_POST['item_id'];
            unset($_POST['item_id'],$_POST['issuedBy']);
            $count =update($tableStore,$id,$_POST);

            $_SESSION['type']="succes";
            $_SESSION['message']="Done";
            header('location: '.BASE_URL."/Admin/store/index.php");
            exit();
        }

        else 
        {
	        $_SESSION['type']="succes";
            $_SESSION['message']="Done";
            header('location: '.BASE_URL."/Admin/store/index.php");
            exit();
        }
    }

    else
    {
	     $_SESSION['type']="error";
         $_SESSION['message']="Add Inventory first";

        header('location:'.BASE_URL."/Admin/store/index.php");
        exit();
    }
}




if(isset($_GET['delete_id']))
{
    $id = $_GET['delete_id'];
    $count = delete($table,$id);
    $_SESSION['type']="succes";
    $_SESSION['message']="Inventory deleted ";

    header('location:'.BASE_URL."/Admin/store/index.php");
    exit();


}



if(isset($_GET['del_id']))
{
    $id = $_GET['del_id'];

    $count = delete($table,$id);

    $_SESSION['type']="succes";
    $_SESSION['message']="Inventory deleted ";

    header('location:'.BASE_URL."/Admin/inventory/index.php");
    exit();

}



if(isset($_GET['del_department']))
{
    $id = $_GET['del_department'];
    $count = delete($tableDepartment,$id);

    $_SESSION['type']="succes";
    $_SESSION['message']="Department deleted ";

    header('location:'.BASE_URL."/Admin/store/department.php");
    exit();

}




if(isset($_GET['message_id']))
{
    $id = $_GET['message_id'];
    $count = delete($tableMessage,$id);

    $_SESSION['type']="succes";
    $_SESSION['message']="Inventory deleted ";

    header('location:'.BASE_URL."/notifications.php");
    exit();

}


if(isset($_GET['deleteOrder_id']))
{
    $id = $_GET['deleteOrder_id'];

    $count = delete($table,$id);

    $_SESSION['type']="succes";
    $_SESSION['message']="Inventory deleted ";

    header('location:'.BASE_URL."/redirect.php");
    exit();
}


if(isset($_GET['remaining_id']))
{
    $id = $_GET['remaining_id'];

    $count = delete($tableStore,$id);

    $_SESSION['type']="succes";
    $_SESSION['message']="Inventory deleted";

    header('location:'.BASE_URL."/Admin/store/remaining.php");
    exit();
}



if(isset($_GET['delInventory_id']))
{
    $id = $_GET['delInventory_id'];

    $count = delete($tableStore,$id);
    $_SESSION['type']="succes";
    $_SESSION['message']="Inventory deleted";

    header('location:'.BASE_URL."/Admin/store/remaining.php");
    exit();
}




if(isset($_POST['create-inventory']))
{
    $errors = validateCreateInventory($_POST);
        
    if(count($errors) === 0)
    {
        unset($_POST["create-inventory"]);
        $_POST['remaining']=$_POST['total'];
        $req_id=create($tableStore,$_POST);
        
        $_SESSION['type']="succes";
        $_SESSION['message']="Inventory Added";

        header('location:'.BASE_URL."/admin/store/remaining.php");
        exit();
    }
    else 
    {      
        $total = $_POST['total'];
        $item = $_POST['item'];
    }
        
}




if(isset($_POST['create-department']))
{
    $errors = validateCreateDepartment($_POST);
        
    if(count($errors) === 0)
    {
        unset($_POST["create-department"]);
        $req_id=create($tableDepartment,$_POST);
        
        $_SESSION['type']="succes";
        $_SESSION['message']="Department Added";

        header('location:'.BASE_URL."/admin/store/department.php");
        exit();
    }
    else 
    {      
        $department = $_POST['department'];
      
    }
        
}


if(isset($_GET['read_id']))
{
        
    $message=selectOne($tableMessage,['id'=> $_GET['read_id']]);

    $user_id = $message['user_id'];
    $messageId=$message['id'];
    $item=$message['item'];
    $quantity=$message['quantity'];
    $status=$message['status'];
    $message=$message['message'];
   
   
}



if(isset($_POST['markAs_read']))
{

  $id =$_POST['id'];
  unset($_POST['markAs_read'],$_POST['id']);
  $_POST['status']=1;

  $count =update($tableMessage,$id,$_POST);
  header('location:'.BASE_URL."/notifications.php");
  exit();




}



  

   
?>
