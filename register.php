<?php
    
    include("path.php");
    include(ROOT_PATH."/app/controllers/users.php");
    guestOnly();



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
    <link rel="stylesheet" href="assets/css/admin.css" />
    <link rel="stylesheet" href="assets/css/header.css" />

    <!--Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Candal&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Candal&display=swap" rel="stylesheet">


    <title>Register </title>
</head>

<body>

    <!--facebook plugin-->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v10.0" nonce="vbGbVe53"></script>
    <!--//facebook plugin-->

    <header>
        <div class="logo">
            <h1 class="logo-text"><span>TotalSecurity.</span>Inventory</h1>
        </div>
        <i class="fa fa-bars menu-toggle"> </i>


    </header>

    <!--page-wrapper-->
    <div class="auth-content">

        <form action="register.php" method="post">
            <h2 class="form-title">Register</h2>

           <!--Display of errors -->

               <?php include(ROOT_PATH."/app/helpers/formErrors.php");?>

            <!-- // Display of errors -->


            <div>
                <label>Username</label>
                <input type="text" name="username" value="<?php echo $username; ?>" class="text-input" />
            </div>


            <div>
                <label>Email</label>
                <input type="email" name="email" value="<?php echo $email; ?>" class="text-input" />
            </div>


            <div>
                <label>Password</label>
                <input type="password" name="password" value="<?php echo $password; ?>" class="text-input" />
            </div>


            <div>
                <label>Password Confirmation</label>
                <input type="password" name="passwordConf" class="text-input" />
            </div>

            <div>
                <button type="submit" name="register-btn" class="btn btn-big">Register</button>
                <p>Or <a href="<?php echo BASE_URL."/login.php"  ?>">Sign in </a> </p>
            </div>

        </form>


    </div>




</body>





</html>