 <header>
        <label for="nav-toggle"><span class="fa fa-bars"></span></label>
        <div class="logo">
            <h1 class="logo-text"><span>TSS.</span>Inventory System</h1>
        </div>
        <i class="fa fa-bars menu-toggle"> </i>

        <ul class="nav">
            <!--The user login and log out-->
            <li>
                <a href="#">
                 <?php if(isset($_SESSION['id'])): ?>
                    <i class="fa fa-user"></i>
                   
                        <?php echo $_SESSION['username']  ?>
                   
                    <i class="fa fa-chevron-down" style="font-size: .8em;"></i>

                <?php endif; ?>

                </a>

                <ul>

                    <li><a href="<?php echo  BASE_URL."/logout.php" ?>">Logout</a> </li>



                </ul>
            </li>


        </ul>




    </header>