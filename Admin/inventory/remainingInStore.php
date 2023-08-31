<?php

include("../../path.php");
include(ROOT_PATH."/app/controllers/requisition.php");
include(ROOT_PATH.'/app/helpers/middleware.php');


if(isset($_GET["search"]))
{
    $items= selectRemaining($_GET['search']);
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
               
                  
            </div>

            <div class="content">

                <h2 class="page-title">View Inventory</h2>

                  <form class="button-group" method="get" action="remainingInStore.php">
                             <input type="text" name="search" class="text-input" placeholder="search.. date in format 2000-07-14" />  <br>
                      </form>

                 <!--Succes message-->
                      <?php include(ROOT_PATH."/app/includes/messages.php"); ?>
                    <!--// Succes message-->

                <div class="table-responsive">

                    <table>
                        <thead>
                            <tr>
                                <th>SN</th>
                                <th>Item</th> 
                                 <th>Remaining</th> 
                                
                               
                            </tr>
                        </thead>

                        <tbody>

                     

                        <?php foreach($items as $key =>$item): ?>
                            <tr>
                                <td><?php echo $key+1 ?> </td>
                                <td><?php echo $item['item']?> </td>
                                 <td><?php echo $item['remaining']?> </td>

                              
                                
                                
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