<?php

include("path.php");
include(ROOT_PATH.'/app/controllers/requisition.php');
include(ROOT_PATH.'/app/helpers/middleware.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_SESSION['id'] = $_POST['user_id'];
        
        if($_SESSION['id']) {
            header('location: redirect.php');
        }
    }
 usersOnly();
 $id = $_SESSION['id'];
 $messageCount= getCountMessages($id);
 
 $messages=selectOne($tableMessage,['user_id'=>$id]);


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
    <link rel="stylesheet" href="assets/css/errors.css" />
    
    

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
     <script src="assets/js/index.js"></script>


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
                       

                        <li> <a href="notifications.php"><i  class="fas fa-envelope"></i><?php if($messageCount >0): ?><sup><?php echo $messageCount ?></sup><?php endif; ?></a></li>
                      

                        <?php if(isset($_SESSION['id'])): ?>
                             <li> <a class="logout" href="<?php echo  BASE_URL."/logout.php" ?>">Logout</a></li>
                        <?php endif; ?>            
                        <li id="close-flyout"><span class="fas fa-times"></span></li>

                    </ul>
                </nav>
            </div>

        </header>



        <section id="hero">
            <div class="fade"></div>

            
              
            <div class="hero-text">
                <h1>Booking and Picking Inventory</h1>
               
                    <div class="info">

                    <?php if(isset($_SESSION['id'])):?> 
                        <span><?php echo $_SESSION['username']  ?> </span>
                        <br>
                         <a class="logout"   href="<?php echo  BASE_URL."/logout.php" ?>" >Logout</a>

                        <?php if($_SESSION['admin']): ?>
                            <a href="<?php echo BASE_URL."/Admin/dashboard.php" ?>">Dashboard</a>
                        <?php endif; ?>


                       <?php else: ?>
                            <a class=""  href="<?php echo  BASE_URL."/login.php" ?>"/> Login / </a>
                            <a  class=""  href="<?php echo  BASE_URL."/register.php" ?>" > Sign up </a>
                      

                        
                    <?php endif; ?>

                    <?php if($_SESSION['admin'] == 0): ?>
                        <h4>Scroll Down to book inventory</h4>
                     <?php endif; ?>
                   

                    </div>
                 

            </div>
        </section>

    </div>

<?php if($_SESSION['admin'] == 0 || $_SESSION['admin'] == 2 ):?>
                                                 
    <section id="how-it-works">
        <div class="container">
            <h2>How it works</h2>
            <div class="flex">
                <span class="fas fa-home"></span>
                <h4>Order Inventory</h4>
               
            </div>

            <div class="flex">
                <span class="fas fa-dollar-sign"></span>
                <h4>Approve Inventory</h4>
             
            </div>

            <div class="flex">
                <span class="fas fa-chart-line"></span>
                <h4>Pick Inventory</h4>
               
            </div>
        </div>
    </section>


 
  
    </section>

    <section id="the-best">
        <div class="flex container">
            <img src="<?php echo BASE_URL."/assets/images/1653121248_background.png" ?>" alt="property 1" />

            <div>
                <h2>View Your Order's Progress</h2>
                <p class="large-paragraph">See the Progress</p>

                <ul>
                    <li>The Item you Ordered</li>
                    <li>The progress of the order</li>
                </ul>
                <a href="redirect.php" class="rounded">View Progress</a>
            </div>

        </div>
    </section>

    

  
    </section>

    <section id="contact">
        <div class="container">
            <h2>Book Inventory</h2>

            <div class="flex">
                <div id="form-container">
                   
               <form method="post" id="contact-form" action="index.php" >

                     <!--Display of errors -->

                    <?php include(ROOT_PATH."/app/helpers/formErrors.php");?>
 
                    <!-- // Display of errors -->

                    <input type="hidden" id="subject" name="user_id" value="<?php echo $_SESSION['id'] ?>" />
                    <input type="hidden" id="subject" name="orderdBy" value="<?php echo $_SESSION['username']. ' ' . $_SESSION['secondname']; ?>" />
                    <input type="hidden" id="subject" name="remainingAfterOrder" value="<?php echo $remainingAfterOrder ?>" />
                    <input type="hidden" id="subject" name="department" value="<?php echo $_SESSION['department'] ?>" />
                   
                    




                    <label for="item Confirmation">Item</label>
                  
                    <select name="item"  id="items"  class="select-dropdown">
                     <option value="" selected disabled hidden>Choose here</option>
                      <?php foreach($items as $key=>$item):?>
                            <?php if(!empty($item_id) && $item_id == $item['id']): ?>
                                <option selected value="<?php echo  $item['item'];?>"> <?php echo $item['item'] ?> </option>
                                <?php else: ?>
                                <option value="<?php echo $item['item']; ?>"> <?php echo $item['item'] ?> </option>
                            <?php endif; ?>
                        <?php endforeach; ?>

                    </select>

                        

                        <label for="Quantity">Quantity</label>
                        <input type="number" id="subject" name="quantity" min="1" max="100"  value="<?php echo $quantity ?>"/>

                        <label for="message">Reason</label>
                        <textarea id="message" name="reason" ><?php echo $reason ?></textarea>

                       <button id="book-inventory" class="btn btn-big" name="book_inventory">Book</button>
                    </form>


                   

                </div>



                 <div id="form-container">
       

                </div>


                 
                

                <div id="address-container"  style="margin-left:0.5rem;">
                    <label>Adress</label>
                    <address>
                       Muchai Drive off Ngong road Nairobi, Kenya
                    </address>


                    <label>Phone</label>
                    <a href="#">+254 717 57 57 57</a> --or--
                      <a href="#">+254 734 12 30 00</a>

                    <label>Email Adress</label>
                    <a href="#">info@totalsecuritykenya.com</a>
                </div>
            </div>
        </div>

    </section>


    <footer>

        <div class="flex container">

            <div class="footer-about">
                <h5>About Stated</h5>
                <p>We are the best Security Suravaillance providers.</p>
            </div>

            <div class="footer-quick-links">
                <h5>Qiuck Links</h5>
                <ul>
                    <li><a href="https://totalsecuritykenya.com/who-we-are/">About Us</a></li>
                    <li><a href="https://totalsecuritykenya.com/">Services</a></li>
                    <li><a href="https://totalsecuritykenya.com/contact-us/">Contact Us</a></li>
                </ul>
            </div>
            
            <div class="footer-subscribe">
                <h5>Total Security Kenya </h5>
                <div id="subscribe-container">
                  
                </div>

                <h5 class="follow-us">Follow Us</h5>
                <ul class="links">
                    <li><a href="#"><span class="fab fa-facebook"></span></a></li>
                    <li><a href="#"><span class="fab fa-twitter"></span></a></li>
                    <li><a href="#"><span class="fab fa-instagram"></span></a></li>
                    <li><a href="#"><span class="fab fa-linkedin-in"></span></a></li>
                </ul>

            </div>
        </div>

        <small>copyright &copy; <script>document.write(/\d{4}/.exec(Date())[0])</script>Total Security Survaillance- All rights reserved 
        </small>

    </footer>

    <script src="assets/js/index.js"></script>
   

</body>

  <?php endif; ?>
    

</html>