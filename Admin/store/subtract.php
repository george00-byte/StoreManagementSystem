<?php

include("../../path.php");
include(ROOT_PATH."/app/controllers/addInventory.php");
include(ROOT_PATH.'/app/helpers/middleware.php');
storeOnly();

$tableStore = 'store';

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


    <title>Add Inventory</title>
</head>

<body>
   <!--Include the Header-->

   <?php include(ROOT_PATH."/app/includes/adminHeader.php")  ?>

   <!--end of the Header-->


    <!--Admin page-wrapper-->
    <input type="checkbox" id="nav-toggle" />
    <div class="admin-wrapper">

        <!--Left sidebar-->
       
        <?php include(ROOT_PATH."/app/includes/adminSidebar.php")   ?>
        <!--//Left sidebar-->   


        <!--Admin content-->
        <div class="admin-content">
            <div class="button-group">
                <a href="remaining.php" class="btn btn-big">Add Inventory</a>
                <a href="index.php" class="btn btn-big">Manage</a>
            </div>

            <div class="content">

                <h2 class="page-title">Remove Inventory</h2>

                <form  action="add.php" method=post enctype="multipart/form-data" >

                     <!--Display of errors -->

                    <?php include(ROOT_PATH."/app/helpers/formErrors.php");?>
 
                    <!-- // Display of errors -->

                    <input type="hidden" name="id" id="name"  class="text-input" value="<?php echo $id; ?>" />
                    <input type="hidden" name="remaining" id="name"  class="text-input" value="<?php echo $remaining; ?>" />
                    <input type="hidden" name="total" id="name"  class="text-input" value="<?php echo $total; ?>" />

                     <div>
                        <label>Item</label>
                        <input type="text" readonly name="item" id="name"  class="text-input" value="<?php echo $item; ?>" />
                    </div>
                    
                    
                    <div>
                        <label>Remove </label>
                        <input type="number" name="add" id="name" min="1" max="100"  class="text-input" />

                    </div>


                    <div>
                     

                    </div>

                    <div>
                        <button name="remove-inventory" class="btn btn-big">Remove Inventory</button>

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





</html>