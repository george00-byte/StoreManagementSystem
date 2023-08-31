<?php

include("../../path.php");
include(ROOT_PATH."/app/controllers/requisition.php");
include(ROOT_PATH.'/app/helpers/middleware.php');



if(isset($_GET["sort"]))
{
    $requisitions=$requisitionsDesc;
}

elseif(isset($_GET['search-term']))
{
     $requisitions=searchTerm($_GET['search-term']);
}

elseif(isset($_GET['pending']))
{
     $requisitions=$requisitionsPending;
}

else 
{
    $requisitions=$requisitions;
}



?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width ,initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--Font Awesome csss link-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css" />

    <!--The css link-->
    <link rel="stylesheet" href="../../assets/css/header.css" />

    <!--Admin styling-->
    <link rel="stylesheet" href="../../assets/css/admin.css" />

    <!--Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Candal&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Candal&display=swap" rel="stylesheet">


    <title>Manage Users</title>
</head>

<body>
   
   <!--Include the Header-->

   <?php include(ROOT_PATH."/app/includes/adminHeader.php")  ?>

   <!--end of the Header-->

    <!--Admin page-wrapper-->
    <input type="checkbox" id="nav-toggle" />
    <div class="admin-wrapper">

        <!--Left sidebar-->
       
        <?php include(ROOT_PATH."/app/includes/adminSidebar.php")  ?>
        <!--//Left sidebar-->



        <!--Admin content-->
        <div class="admin-content">
            <div class="button-group">
               
                 <a href="viewOnlypdf.php" class="btn btn-big" style="color:white; background:blue;" >Print</a>
            </div>

            <div class="content">

                <h2 class="page-title">View Inventory</h2>

                 <!--Succes message-->
                      <?php include(ROOT_PATH."/app/includes/messages.php"); ?>
                    <!--// Succes message-->

                <div class="table-responsive">
                    
                      <form class="button-group" method="get" action="viewOnly.php">
                             <input type="text" name="search-term" class="text-input" placeholder="search.. date in format 2000-07-14" />  <br>
                      </form>

                       <form class="button-group" method="get" action="viewOnly.php">
                             <button class="btn btn-big" style="background:red" name="sort" >Sort</button>
                      </form>
                      <br>

                       <form class="button-group" method="get" action="viewOnly.php">
                             <button class="btn btn-big" style="background:green" name="pending" >Pending</button>
                      </form>

                         <br> 
                       <a href="viewOnly.php" class="btn btn-big" style="color:white; background:gold; " >Unsort</a>
                    

                    <table>
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Item</th>
                                <th>Quantity</th>
                                <th>Department</th>
                                <th>Date</th>
                                <th>ID</th>
                                 <th>Ordered by</th>
                                 <th>Approved by</th>
                                  <th>Issued</th>
                               
                                
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                     
                        <?php foreach($requisitions as $key =>$requisition): ?>
                            <tr>

                            <?php if( $requisition['approve'] == 1):  ?>
                                <td><?php echo $key+1 ?> </td>
                                <td><?php echo $requisition['item']?> </td>
                                <td><?php echo $requisition['quantity']?> </td>
                                <td><?php echo $requisition['department']?> </td>
                                <td><?php echo date('F j, Y', strtotime($requisition['created_at'])); ?> </td>
                                <td> <?php echo $requisition['finalId'] ?></td>

                                <td> <?php echo $requisition['orderdBy'] ?></td>
                                <td><?php echo   $requisition['approvedBy']  ?> </td>
                                

                                    <?php if($requisition['issue'] == 1): ?>
                                        <td><a href="viewOnly.php?id=<?php echo $requisition['id'] ?>?item_id=<?php echo $requisition['item_id'] ?> ?quantity=<?php echo $requisition['quantity'] ?>?approved=<?php echo $requisition['approve'] ?>" class="edit">Issued</a></td>
                                         <td><a href="viewOnlysinglepdf.php?id=<?php echo $requisition['id'] ?>?item_id=<?php echo $requisition['item_id'] ?> ?quantity=<?php echo $requisition['quantity'] ?>?approved=<?php echo $requisition['approve'] ?>" class="edit" style="color:white; background:blue; padding:2px; border-radius:2px" >Print</a></td>
                                    <?php else: ?>
                                        <td><a href="viewOnly.php?id=<?php echo $requisition['id'] ?>?item_id=<?php echo $requisition['item_id'] ?> ?quantity=<?php echo $requisition['quantity'] ?>?approved=<?php echo $requisition['approve'] ?>" class="edit">pending</a></td>
                                         <td><a href="index.php?id=<?php echo $requisition['id'] ?>?item_id=<?php echo $requisition['item_id'] ?> ?quantity=<?php echo $requisition['quantity'] ?>?approved=<?php echo $requisition['approve'] ?>" class="edit" style="color:white; background:blue; padding:2px; border-radius:2px" >Print</a></td>
                                    <?php endif; ?>
                               
                                <td><a href="index.php?delete_id=<?php echo $requisition['id'] ?>" class="delete" onclick="return checkDelete()">delete</a></td>

                             <?php endif;  ?>

                            </tr>
                         <?php endforeach; ?>


                        </tbody>
                     




                    </table>
                </div>

            </div>

        </div>

        <!--Admin content-->


    </div>
    <!--// Admin page-wrapper-->
    <!--JQuery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous"></script>
    <script language="JavaScript" type="text/javascript">
    function checkDelete(){
        return confirm('Are you sure?');
    }
    </script>

    <!--Custom Script-->
    <script src="../../BlogWebsite.js"></script>



</body>





</html>