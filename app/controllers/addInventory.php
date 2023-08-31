<?php

include(ROOT_PATH.'/app/database/db.php');
include(ROOT_PATH.'/app/helpers/validateRequisition.php');

  

$table ='requisition';

$tableStore='store';

$requisitions=selectAll($table);
$items=selectAll($tableStore);


$errors=array();

$id="";
$item ='';
$total ='';
$add="";
$remaining="";
$alert="";





if(isset($_GET['id']))
{
        
    $item=selectOne($tableStore,['id'=> $_GET['id']]);
    $id=$item['id'];
    $total=$item['total'];
    $remaining = $item['remaining'];
    $item =$item['item'];
  
   
     
}


if(isset($_POST['add-inventory']))
{

    $errors = validateAddInventory($_POST);
    
    if(count($errors) === 0)
    {
        $id =$_POST['id'];
        $remaining = $_POST['remaining'];

       
        if($_POST['remaining'] ==0)
        {
             $_POST['remaining']=$_POST['add'];
             $_POST['total']=$_POST['total']+$_POST['add'];
           
             unset($_POST['add-inventory'],$_POST['id'],$_POST['add']);
             $count = update($tableStore,$id,$_POST);
             header('location: '.BASE_URL."/Admin/store/remaining.php");
             exit();
        }
        else
        {
            $_POST['total']=$_POST['total']+$_POST['add'];
            $_POST['remaining']=$_POST['remaining']+$_POST['add'];
            unset($_POST['add-inventory'],$_POST['id'],$_POST['add']);
        
            $count = update($tableStore,$id,$_POST);

            header('location: '.BASE_URL."/Admin/store/remaining.php");
            exit();
	
        }

      

    }
    else 
    {
	       
        $add = $_POST['add'];
        $item=$_POST['item'];
        $total= $_POST['total'];

    }
    
}


if(isset($_POST['add_alert']))
{
   $id=$_POST['id']; 
   unset($_POST['add_alert'],$_POST['id']);
   $count = update($tableStore,$id,$_POST);
   
   header('location: '.BASE_URL."/Admin/store/index.php");
   exit();

}



if(isset($_POST['remove-inventory']))
{

    $errors = validateAddInventory($_POST);
    
    if(count($errors) === 0)
    {
        $id =$_POST['id'];
        $remaining = $_POST['remaining'];

           if($_POST['remaining'] ==0)
        {
             $_POST['remaining']=$_POST['total']-$_POST['add'];
             $_POST['total']=$_POST['total']-$_POST['add'];
           
             unset($_POST['remove-inventory'],$_POST['id'],$_POST['add']);
             $count = update($tableStore,$id,$_POST);
             header('location: '.BASE_URL."/Admin/store/remaining.php");
             exit();
        }
        else
        {
            $_POST['total']=$_POST['total']-$_POST['add'];
            $_POST['remaining']=$_POST['remaining']-$_POST['add'];
            unset($_POST['remove-inventory'],$_POST['id'],$_POST['add']);
        
            $count = update($tableStore,$id,$_POST);
            header('location: '.BASE_URL."/Admin/store/remaining.php");
            exit();
	
        }

    }
    else 
    {
	       
        $add = $_POST['add'];
        $item=$_POST['item'];
        $total= $_POST['total'];

    }
    
}









?>