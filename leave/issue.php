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


    <title>Edit Users</title>
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
                <a href="index.php" class="btn btn-big" style="color:white; background:gold;">Manage</a>
                 <a href="decline.php?id=<?php echo $requisition['id']?>" class="btn btn-big" style="color:white; background:red;">Decline</a>
            </div>

            <div class="content">

                <h2 class="page-title">Edit Inventory</h2>


                  <form  action="edit.php" method=post enctype="multipart/form-data" >

                     <!--Display of errors -->

                    <?php include(ROOT_PATH."/app/helpers/formErrors.php");?>
 
                    <!-- // Display of errors -->

                     <input type="hidden" name="id"  value="<?php echo $id ?>" />
                     <input type="hidden" name="issuedBy" id="subject"  class="text-input" value="<?php echo $_SESSION['username']. ' ' . $_SESSION['secondname']; ?>" />
                    



                        


                    <div>
                        <label>Type of Leave</label>
                        <input type="text" name="leaveType" id="name" readonly  class="text-input" value="<?php echo $leaveType; ?>" />
                    </div>


                    <div>
                        <label>Starting Date</label>
                         <input type="text" name="starting_at" id="subject" readonly  class="text-input" value="<?php echo $starting; ?>" />
                    </div>


                    <div>
                        <label>Ending Date</label>
                         <input type="text" name="ending_at" id="subject" readonly class="text-input" value="<?php echo $ending; ?>" />

                    </div>


                   

                     <div>
                        <label>Reason For Requisition</label>
                       <textarea id="message" &nbsp name="reason" readonly ><?php echo htmlentities($reason);?></textarea>

                    </div>



                    <div>
                       
                        <label>

                            <?php if($issue ==1): ?>
                                <input type="checkbox" name="issue" checked >
                                Issue
                            <?php else: ?>
                                <input type="checkbox" name="issue"  >
                                Issue

                            <?php endif; ?>

                        </label>


                    </div>

                    <div>
                        <button name="issue_leave" class="btn btn-big">Issue Inventory</button>

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