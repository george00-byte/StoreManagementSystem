<?php

include("path.php");
include(ROOT_PATH.'/app/controllers/requisition.php');
include(ROOT_PATH.'/app/helpers/middleware.php');
$tableStoreItems = selectAll($tableStore);
 usersOnly();

if(isset($_SESSION['id']))
{
   $id=$_SESSION['id']; 
   $uniqueMessages=getMessages($id);

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
                        <li> <a href="https://totalsecuritykenya.com/">Main Site</a></li>
                        <li> <a href="https://totalsecuritykenya.com/who-we-are/">About</a></li>
                        <li> <a href="https://totalsecuritykenya.com/contact-us/">Contact</a></li>
                    

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

                 <li class="step-wizard-item col-sm">
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
                                            <th scope="col">quantity</th>
                                            <th scope="col">Messages</th>
                                            
                                             <th colspan = "3"scope="col">Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>

        
                                    <?php if(isset($_SESSION['id'])):  ?>
                                     
                                        <?php foreach($uniqueMessages as $key=> $messages ):?>
                                            <tr>
                                                <td><?php echo $key+1; ?> </td>
                                                 <td> <?php echo $messages['item']; ?> </td>
                                                  <td><?php echo $messages['quantity']; ?> </td>
                                                <td> <?php echo $messages['message']; ?> </td>
                                                <td>
                                                <form method="post" id="contact-form" action="notifications.php">
                                                       
                                                        <input type="hidden" id="subject" name="id" value="<?php echo $messages['id']?>" />
                                                        <input type="hidden" id="subject" name="item" value="<?php echo $messages['item']?>" />
                                                        <input type="hidden" id="subject" name="read" value="<?php echo $messages['status']?>" />
                                                          <input type="hidden" id="subject" name="message" value="<?php echo $messages['message'] ?>" />
                                                        <input type="hidden" id="subject" name="quantity" value="<?php echo $messages['quantity'] ?>" />
                                                        <input type="hidden" id="subject" name="user_id" value="<?php echo $messages['user_id'] ?>" />
                                                         <td><a href="read.php?read_id=<?php echo $messages['id'] ?>" class="delete btn btn-danger" >Read</i></a></td> 
                                                     
                                                </from>
                                                </td>
                                               
                                                <td><a href="notifications.php?message_id=<?php echo $messages['id'] ?>" class="delete btn btn-danger" onclick="return checkDelete()"><i class="fas fa-trash"></i></a></td> 
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