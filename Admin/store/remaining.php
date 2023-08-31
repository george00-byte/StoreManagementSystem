<?php

include("../../path.php");
include(ROOT_PATH."/app/controllers/requisition.php");
include(ROOT_PATH.'/app/helpers/middleware.php');
storeOnly();


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
                <a href="remove.php" class="btn btn-big" style="color:white; background:red;">Remove Inventory</a>
                <a href="index.php" class="btn btn-big" style="color:white; background:gold;">Manage </a>
                  
            </div>

            <div class="content">

                <h2 class="page-title">Manage Inventory</h2>

                 <!--Succes message-->
                      <?php include(ROOT_PATH."/app/includes/messages.php"); ?>
                    <!--// Succes message-->

                <div class="table-responsive">

                    <table>
                        <thead>
                            <tr>

                               <form class="button-group" method="get" action="remaining.php">
                                    <input type="text" name="search" class="text-input" placeholder="search.. date in format 2000-07-14" />  <br>
                                </form>
                                <th>SN</th>
                                <th>Item</th> 
                                 <th>Remaining</th> 
                                
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                     

                        <?php foreach($items as $key =>$item): ?>
                            <tr>
                                <td><?php echo $key+1 ?> </td>
                                <td><?php echo $item['item']?> </td>
                                 <td><?php echo $item['remaining']?> </td>

                              
                                
                                <td><a href="add.php?id=<?php echo $item['id'] ?>"   class="edit">ADD</a></td>
                                <td><a href="alert.php?id=<?php echo $item['id'] ?>"   class="edit">Set Alert</a></td>
                                <td><a href="remaining.php?delInventory_id=<?php echo $item['id'] ?>" class="delete" onclick="return checkDelete()">delete</a></td>

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