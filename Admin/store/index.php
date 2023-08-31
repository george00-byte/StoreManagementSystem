<?php

include("../../path.php");
include(ROOT_PATH."/app/controllers/requisition.php");
include(ROOT_PATH.'/app/helpers/middleware.php');
storeOnly();


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


$remainingArray = getRemaining();
$alertsArray = getAlert();
$alertItem = getItem();





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
                <a href="create.php" class="btn btn-big">Create Inventory</a>
                <a href="remaining.php" class="btn btn-big">Add Inventory </a>
                <br> <br> <br>
                 <a href="pdf.php" class="btn btn-big" style="color:white; background:blue;" >Print</a> <a href="index.php" class="btn btn-big" style="color:white; background:gold; " >Unsort</a>
                      
                      <br>
            </div>

           

            <div class="content">

            

                <h2 class="page-title">Manage Inventory</h2>

                 <!--Succes message-->
                      <?php include(ROOT_PATH."/app/includes/messages.php"); ?>
                    <!--// Succes message-->

                     <?php for ($i = 0; $i < count($alertsArray); $i++) {
                    if ($alertsArray[$i]['alert'] >= $remainingArray[$i]['remaining']) 
                    {
                        // The alert and remaining values are equal, generate alert
                        echo '<div id="alert' . $i . '" style="color: white; font-weight: italic; background-color: #d16f6f; width: 100%;">' . $alertItem[$i]['item'] . ' Quantity is below Minimum</div>' . PHP_EOL;
                        echo '<script>';
                        echo 'setTimeout(function() {';
                        echo 'var alertDiv = document.getElementById("alert' . $i . '");';
                        echo 'alertDiv.style.display = "none";';
                        echo '}, 7000);'; // Change "5000" to the desired duration in milliseconds (e.g., 5000 milliseconds = 5 seconds)
                        echo '</script>';
                    }
                    }
                    ?>

                <div class="table-responsive">
                    
                      <form class="button-group" method="get" action="index.php">
                             <input type="text" name="search-term" class="text-input" placeholder="search.. date in format 2000-07-14" />  <br>
                      </form>

                       <form class="button-group" method="get" action="index.php">
                             <button class="btn btn-big" style="background:red" name="sort" >Sort</button>        <form class="button-group" method="get" action="index.php">
                             <button class="btn btn-big" style="background:green" name="pending" >Pending</button>
                      </form>
                      </form>    <br> 
                       

                      

                     
                    

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
                                 <th>Document</th>
                                  <th>Status</th>
                               
                                
                                <th colspan="2">Action</th>
                            </tr>
                        </thead>

                        <tbody>

                     
                        <?php foreach($requisitions as $key =>$requisition): ?>
                            <tr>

                            <?php if( $requisition['approve'] == 1): ?>
                                <td><?php echo $key+1 ?> </td>
                                <td><?php echo $requisition['item']?> </td>
                                <td><?php echo $requisition['quantity']?> </td>
                                <td><?php echo $requisition['department']?> </td>
                                <td><?php echo date('F j, Y', strtotime($requisition['created_at'])); ?> </td>
                                <td> <?php echo $requisition['finalId'] ?></td>

                                <td> <?php echo $requisition['orderdBy'] ?></td>
                                <td><?php echo   $requisition['approvedBy']  ?> </td>

                                  <td><a  target=”_blank” href="pdfdownload.php?document=<?php echo $requisition['document'] ?>" class="edit"><?php echo $requisition['document'] ?></a></td>
                                

                                    <?php if($requisition['issue'] == 1): ?>
                                        <td><a href="edit.php?id=<?php echo $requisition['id'] ?>?item_id=<?php echo $requisition['item_id'] ?> ?quantity=<?php echo $requisition['quantity'] ?>?approved=<?php echo $requisition['approve'] ?>" class="edit">Issued</a></td>
                                         <td><a href="singlePdf.php?id=<?php echo $requisition['id'] ?>?item_id=<?php echo $requisition['item_id'] ?> ?quantity=<?php echo $requisition['quantity'] ?>?approved=<?php echo $requisition['approve'] ?>" class="edit" style="color:white; background:blue; padding:2px; border-radius:2px" >Print</a></td>
                                    <?php else: ?>
                                        <td><a href="edit.php?id=<?php echo $requisition['id'] ?>?item_id=<?php echo $requisition['item_id'] ?> ?quantity=<?php echo $requisition['quantity'] ?>?approved=<?php echo $requisition['approve'] ?>" class="edit">View</a></td>
                                         <td><a href="index.php?id=<?php echo $requisition['id'] ?>?item_id=<?php echo $requisition['item_id'] ?> ?quantity=<?php echo $requisition['quantity'] ?>?approved=<?php echo $requisition['approve'] ?>" class="edit" style="color:white; background:blue; padding:2px; border-radius:2px" >Print</a></td>
                                    <?php endif; ?>
                               
                               

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