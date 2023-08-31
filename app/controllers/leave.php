<?php

   include(ROOT_PATH.'/app/database/db.php');
   include(ROOT_PATH.'/app/helpers/validateLeave.php');

  

   $tableleaveType ='leavetype';
   $tableleave="requestleave";

   $errors=array();


   $leaves = selectAll($tableleaveType);
   $leaveRequests = selectAll($tableleave);


   $leave="";
   $starting="";
   $ending="";
   $reason="";
   $approve="";
   $issue="";







if(isset($_POST["apply_leave"]))
{
    $errors = validateLeave($_POST);

    if(count($errors) == 0)
    {
        $_POST['reason']=htmlentities($_POST['reason']);
        unset($_POST["apply_leave"]);

        $req_id=create($tableleave,$_POST);
        $_SESSION['message']="4";

        header('location:'.BASE_URL."/leaveRedirect.php");
        exit();


    }
                
}


if(isset($_POST['create_leave']))
{
    $errors = validateCreateLeave($_POST);
        
    if(count($errors) === 0)
    {
        unset($_POST["create_leave"]);
        $req_id=create($tableleaveType,$_POST);
        
        $_SESSION['type']="succes";
        $_SESSION['message']="Leave Added";

        header('location:'.BASE_URL."/admin/leave/leave.php");
        exit();
    }
    else 
    {      
        $leave = $_POST['leaveType'];
      
    }
        
}


if(isset($_GET['del']))
{
    $id = $_GET['del'];

    $count = delete($tableleaveType,$id);

    $_SESSION['type']="succes";
    $_SESSION['message']="leave deleted ";

    header('location:'.BASE_URL."/Admin/leave/leave.php");
    exit();
}



if(isset($_GET['id']))
{
        
    $leave=selectOne($tableleave,['id'=> $_GET['id']]);

    $id=$leave['id'];
    $leaveType=$leave['leaveType'];
    $starting= $leave['starting_at'];
    $ending= $leave['ending_at'];
    $approvedBy=$leave['approvedBy'];
    $reason=$leave['reason'];
    $approve=$leave['approve'];
    $issue=$leave['issue'];

   
}


if(isset($_POST['approve_leave']))
{

  $id =$_POST['id'];
  unset($_POST['approve_leave'],$_POST['id']);
  $_POST['approve']=isset($_POST['approve'])?1:0;
  $count =update($tableleave,$id,$_POST);
  header('location:'.BASE_URL."/admin/leave/index.php");
  exit();




}


if(isset($_POST['issue_leave']))
{

  $id =$_POST['id'];
  $_POST['approve']=1;
  unset($_POST['issue_leave'],$_POST['id']);
  $_POST['issue']=isset($_POST['issue'])?1:0;
  $count =update($tableleave,$id,$_POST);
  header('location:'.BASE_URL."/admin/leave/leaveIssue.php");
  exit();




}













?>