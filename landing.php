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
                <a id="logo" href="#"><span>TSS</span>Inventory System</a>

                <nav>
                    <button id="nav-toggle" class="hamburger-menu">
                        <span class="strip"></span>
                        <span class="strip"></span>
                        <span class="strip"></span>
                    </button>
                   

                    <ul id="nav-menu" class="ls-sticky">
                        <li> <a href="index.php" >Store Requisition</a></li>
                        <li> <a href="leave.php" >Leave Requisition</a></li>


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
                <h1></h1>
               
                    <div class="info">

                    <?php if(isset($_SESSION['id'])):?> 
                        <span style="font-size:2rem"><?php echo $_SESSION['username']  ?> </span>
                        <br>
                         <a class="logout" style="font-size:2rem"  href="<?php echo  BASE_URL."/logout.php" ?>" >Logout</a>

                        <?php if($_SESSION['admin']): ?>
                            <a style="font-size:2rem" href="<?php echo BASE_URL."/Admin/dashboard.php" ?>">Dashboard</a>
                        <?php endif; ?>


                       <?php else: ?>
                            <a class="" href="<?php echo  BASE_URL."/login.php" ?>"/> Login / </a>
                            <a  class=""  href="<?php echo  BASE_URL."/register.php" ?>" > Sign up </a>
                      

                        
                    <?php endif; ?>
                   

                    </div>
                 

            </div>
        </section>

    </div>



</html>


