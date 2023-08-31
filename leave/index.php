<?php

include("../../path.php");
include(ROOT_PATH."/app/controllers/leave.php");
include(ROOT_PATH.'/app/helpers/middleware.php');






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
                <a href="index.php" class="btn btn-big" style="color:white; background:gold;"  >Manage </a>
            </div>

            <div class="content">

                <h2 class="page-title">Manage Inventory</h2>

                 <!--Succes message-->
                      <?php include(ROOT_PATH."/app/includes/messages.php"); ?>
                 <!--// Succes message-->

                <div class="table-responsive">
                    
                          <form class="button-group" method="get" action="index.php">
                              <input type="text" name="search-term" class="text-input" placeholder="search.. date in format 2000-07-14" />  <br>
                          </form> 
                            
                          <form class="button-group" method="get" action="index.php">
                                <button class="btn btn-big" style="background:red" name="sort" >Sort</button>
                          </form>  <br>
                         
                           <form class="button-group" method="get" action="index.php">
                                <button class="btn btn-big" style="background:green" name="pending" >Pending</button>
                          </form>

                    <table>
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Leave Type</th>
                                <th>Starting Date</th>
                                <th>Ending Date</th>
                                <th> By</th>
                                <th>Declined</th>
                               
                                
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                        <?php foreach($leaveRequests as $key =>$leave): ?>
                            <tr>

                                <td><?php echo $key+1 ?> </td>
                            
                                <td><?php echo $leave['leaveType']?> </td>
                                <td><?php echo $leave['starting_at']?> </td>
                                <td><?php echo $leave['ending_at']?> </td>
                                 <td><?php echo $leave['orderdBy']?> </td>
                                  <?php if($leave['decline'] == 1): ?>
                                    <td class="delete"><?php echo "Declined"?> </td>
                                        <?php else: ?>
                                    <td class="delete"><?php echo "No"?> </td>
                                   <?php endif; ?>

                                <?php if( $leave['approve'] == 1): ?>
                                   <td><a href="edit.php?id=<?php echo $leave['id'] ?>" class="edit">Approved</a></td>

                                <?php elseif($leave['approve'] == 0):?>
                                    <td><a href="edit.php?id=<?php echo $leave['id'] ?>" class="edit">Pending</a></td>

                                <?php endif; ?>

                                <?php if($leave['issue'] == 0):?>
                                    <td><a href="index.php?del_id=<?php echo $leave['id'] ?>" onclick="return confirm('Are you sure?')" class="delete" >delete</a></td>
                                    <?php else: ?>
                                    <td><a href="index.php"  class="delete" >Issued</a></td>
                                <?php endif; ?>

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