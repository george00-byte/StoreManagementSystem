<?php

include("../../path.php");
include(ROOT_PATH."/app/controllers/requisition.php");
include(ROOT_PATH.'/app/helpers/middleware.php');

require_once ROOT_PATH.'/vendor/autoload.php';
use Dompdf\Dompdf;


storeOnly();


$html='<!DOCTYPE html>
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


    <title>Edit Users</title>
</head>

<body>
   <!--Include the Header-->

   <?php include(ROOT_PATH."/app/includes/adminHeader.php")  ?>

   <!--end of the Header-->


    <!--Admin page-wrapper-->
    
    <div class="admin-wrapper">

        
        <!--Left sidebar-->
       
        <?php include(ROOT_PATH."/app/includes/adminSidebar.php")  ?>
        <!--//Left sidebar-->    


        <!--Admin content-->
        <div class="admin-content">
           

            <div class="content">

                <h1 class="page-title">Requisition Form</h1>
                 <h3 class="page-title">ID '.$uniqueId.'</h3>
                


                  <form  action="edit.php" method=post  >

                     <!--Display of errors -->

                    <?php include(ROOT_PATH."/app/helpers/formErrors.php");?>
 
                    <!-- // Display of errors -->

                     <input type="hidden" name="id"  value="<?php echo $id ?>" />

                     <input type="hidden" name="quantity"  value="<?php echo $total ?>" />
                     <input type="hidden" name="remaining"  value="<?php echo $remaining ?>" />
                     <input type="hidden" name="item_id"  value="<?php echo $item_id ?>" />
                      

                    <label style="text-allign:center; margin-top:0px">Item</label>
                    <div style="text-allign:center; margin-top:10px; align-content:center;">
                        
                        <input  style="margin-top:1px" type="text" name="item" id="name" readonly  class="text-input" value="'.$item.'" />
                    </div>

                     <label>Quantity</label> 
                    <div style="text-allign:center; margin-top:10px; align-content:center;">
                        
                         <input  type="text" name="quantity" id="subject" readonly  class="text-input" value="'.$quantity.'" />
                    </div>
                    
                        
                     <label style="text-allign:center;">Department</label>
                    <div style="text-allign:center; margin-top:10px; align-content:center;">
                       
                         <input type="text" name="department" id="subject" readonly class="text-input" value="'. $department.'" />

                    </div>
                    
                 
                   

                     <div style="text-allign:center; margin-top:10px; align-content:center;">
                        <label>Reason For Requisition</label>
                       <textarea id="message" &nbsp name="reason" readonly > '.htmlentities($reason).'</textarea>

                    </div>

                    <h5>Date of Order: '.$created_at.'</h5>
                    <h5>Ordered By: '.$orderdBy.'</h5>
                    <h5>Approved By: '.$approvedBy.'</h5>
                    <h5>Issued By: '.$issuedBy.'</h5>
                    
                    <h5>Date printed: '.date('Y-m-d').'</h5>
                    
                    
                    
                    




                    <div>
                       

                    </div>

                


                </form>



            </div>

        </div>

        <!--Admin content-->


    </div>
    <!--// Admin page-wrapper-->
    <!--JQuery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous"></script>


    <!--Ck editor-->
    <script src="https://cdn.ckeditor.com/ckeditor5/28.0.0/classic/ckeditor.js"></script>

    

    <!--Custom Script-->
    <script src="../../assets/js/index.js"></script>

 



</body>





</html>';


$dompdf = new Dompdf();
$dompdf -> loadHtml($html);
$dompdf->setPaper('A5', 'potrait');
$dompdf->render();
$dompdf->stream('invoice.pdf',['Attachment'=>0]);





?>

