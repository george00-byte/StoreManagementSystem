<?php

include("../../path.php");
include(ROOT_PATH."/app/controllers/requisition.php");
include(ROOT_PATH.'/app/helpers/middleware.php');

require_once ROOT_PATH.'/vendor/autoload.php';
use Dompdf\Dompdf;

printOnly();

$html='!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width ,initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!--Font Awesome csss link-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css" />

    <!--The css link-->
    <link rel="stylesheet" href="../../assets/css/header.css" />

        <!--Boostrap cdn css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!--//Boostrap cdn css-->


    <!--Admin styling-->
    <link rel="stylesheet" href="../../assets/css/admin.css" />

    <!--Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Candal&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Candal&display=swap" rel="stylesheet">


    <title>Inventory pdf</title>
</head>

<body>
   


  
    <div class="admin-wrapper">

     


        <!--Admin content-->
        <div class="admin-content">
          

            <div class="content">

                <h2 class="page-title">Inventory Information</h2>

                 <!--Succes message-->
                      <?php include(ROOT_PATH."/app/includes/messages.php"); ?>
                    <!--// Succes message-->

                <div class="table-responsive">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="border:1px solid;text-align:center;">SN</th>
                                <th  style="border:1px solid;text-align:center;">Item</th>
                                <th  style="border:1px solid;text-align:center;">Quantity</th>
                                <th  style="border:1px solid;text-align:center;">Department</th>
                                <th  style="border:1px solid;text-align:center;">Date</th>
                               
                                 <th  style="border:1px solid;text-align:center;">Approved by</th>
                                  <th  style="border:1px solid;text-align:center;">Issued by</th>
                                 <th  style="border:1px solid;text-align:center;">Ordered by</th>
                                  <th  style="border:1px solid;text-align:center;">Final Id</th>

                               
                              
                            </tr>
                        </thead>

                        <tbody>';


                        foreach($requisitions as $key =>$requisition)
                        {
                             if ($requisition['issue'] == 1)
                             {
                                $html .='
                                    <tr  style="border:1px solid;text-align:center;">
                                    <td  style="border:1px solid;text-align:center;">'.$key+1 .'</td>
                                    <td  style="border:1px solid;text-align:center;">'.$requisition['item'].'</td>
                                    <td  style="border:1px solid;text-align:center;">'.$requisition['quantity'].'</td>

                                    <td style="border:1px solid;text-align:center;">'.$requisition['department'].'</td>
                                    <td style="border:1px solid;text-align:center;">'. date('F j, Y', strtotime($requisition['created_at'])).'</td>
                                
                                    <td style="border:1px solid;text-align:center;">'.$requisition['approvedBy'].'</td>
                                    <td style="border:1px solid;text-align:center;">'.$requisition['issuedBy'].'</td>
                                     <td style="border:1px solid;text-align:center;">'.$requisition['orderdBy'].'</td>
                                      <td style="border:1px solid;text-align:center;">'.$requisition['finalId'].'</td>

                                    </tr>';
                             }
                        }
                            
      
$html .=' </tbody>
                     




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

<!--Custom Script-->
<script src="../../BlogWebsite.js"></script>



</body>





</html>';
                  


$dompdf = new Dompdf();
$dompdf -> loadHtml($html);
$dompdf->setPaper('A4', 'potrait');
$dompdf->render();
$dompdf->stream('invoice.pdf',['Attachment'=>0]);




?>



              