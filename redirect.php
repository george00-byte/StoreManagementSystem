<?php

include("path.php");
include(ROOT_PATH.'/app/controllers/requisition.php');
include(ROOT_PATH.'/app/helpers/middleware.php');
$tableStoreItems = selectAll($tableStore);
 usersOnly();

if(isset($_SESSION['id']))
{
   $id=$_SESSION['id']; 
   $uniqueOrders=getUniqueOrders($id);

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

    <!--Sleek carousel-->
    <link type="text/css" rel="stylesheet" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">


    <!--The css link-->
    <link rel="stylesheet" href="assets/css/styles.css" type="text/css" />
    <link rel="stylesheet" href="assets/css/errors.css" type="text/css" />
    <link rel="stylesheet" href="assets/css/progress.css" />
     


    <!--Boostrap cdn css-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <!--//Boostrap cdn css-->
    <!--Google fonts -->
    <script href="https://kit.fontawesome.com/95dc93da07.js"></script>

    <!--Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Candal&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Candal&display=swap" rel="stylesheet">

    <!--JQuery-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.js" integrity="sha512-n/4gHW3atM3QqRcbCn6ewmpxcLAHGaDjpEBu4xZd47N0W2oQ+6q7oc3PXstrJYXcbNU1OHdQ1T7pAP+gi5Yu8g==" crossorigin="anonymous"></script>

    <!--Sleek carousel-->
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <link type="text/css" rel="stylesheet" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">



    <title>Total.Security</title>
</head>
    
<body>
    <div id="header-hero-container">
        <header>
            <div class="flex container">
                <a id="logo" href="#"><span>TotalSecurity.</span>Inventory</a>

                <nav>
                    <button id="nav-toggle" class="hamburger-menu">
                        <span class="strip"></span>
                        <span class="strip"></span>
                        <span class="strip"></span>
                    </button>


                    <ul id="nav-menu" class="ls-sticky">
                        <li> <a href="index.php" class="active">Home</a></li>
                        <li> <a href="multiple.php" >Choose multiple items</a></li>
           
                        <li> <a href="https://totalsecuritykenya.com/who-we-are/">About</a></li>
                        


                        <?php if(isset($_SESSION['id'])): ?>
                        <li> <a class="logout" href="<?php echo  BASE_URL." /logout.php" ?>">Logout</a></li>
                        <?php endif; ?>

                        <li id="close-flyout"><span class="fas fa-times"></span></li>

                    </ul>
                </nav>
            </div>

        </header>
      
            
      


         <section class="step-wizard container">
           
               
         
            <ul class="step-wizard-list row">
                <li class="step-wizard-item col-sm">
                    <span class="progress-count">1</span>
                    <span class="progress-label">Ordered</span>
                </li>
                     <!--Display of errors -->

                    <?php include(ROOT_PATH."/app/helpers/formErrors.php");?>
 
                    <!-- // Display of errors -->

                <li class="step-wizard-item  current-item col-sm">
                    <span class="progress-count">1</span>
                    <span class="progress-label">Approved</span>
                </li>

                <li class="step-wizard-item col-sm">
                    <span class="progress-count">1</span>
                    <span class="progress-label">Issued</span>
                </li>

             
               
            </ul>

        </section>


        
                     
 
                 <div class="recent-grid">
                <div class="projects">
                    <div class="card">

                       

                        <div class="card-body">
                            <div class="table-responsive">
                             <h3>Your Requisitions</h3>
                                   

                                    <table class="table table-dark">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Item</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Status</th>
                                            <th scope="col">Action</th>
                                            
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            if (!isset($_SESSION['message']))
                                            {
                                                // If 'message' key doesn't exist, set it to zero
                                                $_SESSION['message'] = 0;
                                            }

                                        ?>


                                         <?php if($_SESSION['message']=='4'): ?>
                                           <?php echo
                                               '<div class="alert alert-success alert-dismissible fade show" role="alert">
                                                  <strong>Inventory ordered!</strong> Success.
                                                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>' ?>

                                          <?php endif;?>


                                         <?php if($_SESSION['message']=='5'): ?>
                                         
                                           <?php echo
                                               '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                                                  <strong>Not enough Inventory!</strong> Check with the manager.
                                                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                </div>' ?>
                                              
                                          <?php endif;?>

                                         
        
                                    <?php if(isset($_SESSION['id'])):  ?>
                                     
                                        <?php foreach($uniqueOrders as $key=> $uniqueOrder ):?>
                                            <tr>
                                                <td><?php echo $key+1; ?> </td>
                                                <td> <?php echo $uniqueOrder['item']; ?> </td>
                                                <td><?php echo $uniqueOrder['quantity']; ?> </td>

                                                <?php if ($uniqueOrder['approve'] == 1): ?>
                                                    <td><?php echo "Approved"; ?></td>
                                                <?php elseif ($uniqueOrder['approve'] == 0): ?>
                                                    <?php if ($uniqueOrder['issue'] == 1 ): ?>
                                                        <td><?php echo "Issued"; ?></td>
                                                    <?php elseif ($uniqueOrder['decline'] == 1): ?>
                                                        <td><a href="reason.php?id=<?php echo $uniqueOrder['id'] ?>" class="delete btn btn-warning " role="button" >Declined</a></td>
                                                    <?php else: ?>
                                                        <td><?php echo "Waiting approval"; ?></td>
                                                    <?php endif; ?>
                                                <?php endif; ?>

                                                <?php if($uniqueOrder['approve'] ==0):  ?>
                                                    <td><a href="index.php?deleteOrder_id=<?php echo $uniqueOrder['id'] ?>" class="delete btn btn-danger" onclick="return checkDelete()">delete</a></td>
                                                <?php else: ?>
                                                     <td><a href="redirect.php" class="delete btn btn-info disabled" role="button" aria-disabled="true">Approved</a></td>
                                                <?php endif; ?>
                                               
                                            </tr>
                                         <?php endforeach; ?>

                                     <?php endif;?>
                                        </tbody>
                                    </table>

                                    

                                    </tbody>

                                </table>

                            </div>
                        </div>
                    </div>
                </div>
                </div>



                    <div class="recent-grid">
                <div class="projects">
                    <div class="card">

                       

                     
                    </div>
                </div>
                </div>



        <footer>

            <div class="flex container">

                <div class="footer-quick-links">
                    <h5></h5>
                    <ul>
                    </ul>
                </div>

                <div class="footer-subscribe">
                    <h5></h5>
                    <div id="subscribe-container">

                    </div>

                    <h5 class="follow-us"></h5>
                    <ul class="links">
                    </ul>

                </div>
            </div>

            <small>
                copyright &copy;
                <script>document.write(/\d{4}/.exec(Date())[0])</script>Total Security Survaillance- All rights reserved
            </small>

        </footer>

        <script src="assets/js/index.js"></script>
        <!--Boostrap cdn js-->
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>
        <!--Boostrap cdn js-->

        <script language="JavaScript" type="text/javascript">
        function checkDelete(){
            return confirm('Are you sure?');
        }
       </script>

</body>
    

</html>