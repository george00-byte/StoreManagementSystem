<?php

include("../path.php");

include(ROOT_PATH."../app/controllers/users.php");


adminOnly();
$tableUsers='users';

$users = selectAll($tableUsers);

$adminPic= selectOne($tableUsers,['username'=>$_SESSION['username']]);


$table='requisition';
$requisitions = selectAll($table);


$tableStore = 'store';
$tableStoreItems = selectAll($tableStore);


$CountItemsInProgress=getNumberOfInventoryInProgress();

$numberOfOrders=getNumberOfInventoryOrdered();

$dept=$_SESSION['department'];
$requisitionInDept=selectAllInDepartment($dept);

$getNumberOfInventoryOrderedInDept=getNumberOfInventoryOrderedInDept($dept);
$getNumberOfInventoryInProgressDept=getNumberOfInventoryInProgressDept($dept);





?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width ,initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Admin Dashboard</title>

    <!--Font Awesome css link-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css" />

    <!--Sleek carousel-->
    <link type="text/css" rel="stylesheet" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">


    <!--Google fonts -->
    <script href="https://kit.fontawesome.com/95dc93da07.js"></script>

    <!--Google fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Candal&display=swap" rel="stylesheet">

    <!--Line awesome -->
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <link rel="stylesheet" href="../assets/css/dashboard.css" />


</head>


<body>

    <input type="checkbox" id="nav-toggle"/>
    <div class="sidebar">
        <div class="sidebar-brand">

            <h2 class="logo"> <span><label>TotalSecurity</label></span></h2>

        </div>

        <div class="sidebar-menu">
           

            
                 <ul>
                  <li>
                    <a href="<?php echo BASE_URL."/admin/dashboard.php"?>" class="active">
                        <span class="las la-igloo"></span>
                        <span>Dashboard</span>
                    </a>

                 </li>
                   
            <?php if($_SESSION['admin']=== 1): ?>
                <li>
                    <a href=" <?php echo BASE_URL."/admin/users/index.php"?> ">
                        <span class="las la-users"></span>
                        <span>Users</span>
                    </a>

                </li>

                <li>
                    <a href="<?php echo BASE_URL."/admin/store/index.php"?>">
                        <span class="las la-clipboard-list"></span>
                        <span>Issue</span>
                    </a>

                </li>

            <?php endif; ?>
             </ul>

             <ul>
                
               
             <?php if($_SESSION['admin'] ===2):?>
                <li>
                    <a href="<?php echo BASE_URL."/admin/inventory/index.php"?>">
                        <span class="las la-receipt"></span>
                        <span>Approve</span>
                    </a>

                </li>
            <?php endif; ?>

                <li>
                    <a href=" <?php echo BASE_URL."/index.php"?> ">
                        <span class="las la-user-circle"></span>
                        <span>Home site</span>
                    </a>

                </li>



            </ul>

       
               
        </div>
    </div>

    <div class="main-content">
        <header>
            <h2>
                <label for="nav-toggle">
                    <span class="las la-bars"></span>
                </label>
                Dashboard
            </h2>

            <div class="search-wrapper">
                <span class="las la-search"></span>
                <input type="search" placeholder="Search here" />

            </div>


        
            <div class="user-wrapper">

            <?php if(isset($_SESSION['id'])): ?>
                <img src="<?php echo BASE_URL."../assets/images/profile.jpg"; ?>" width="30px" height="30px" />

                <div class="user-info">
                    <h4> <?php echo $_SESSION['username']?> </h4>
                    
                    <ul>
                        <li><small>Super admin</small></li>
                        <ul>
                            <li>
                                <a href="<?php echo  BASE_URL."/logout.php" ?>">Logout</a>
                            </li>
                        </ul>
                    </ul>

                </div>
            <?php endif; ?>

            </div>

       

        </header>

        <main>
            <div class="cards">
                <div class="card-single">
                    <div>
                        <h1> </h1>
                        <span>Customers</span>
                    </div>

                    <div>
                        <span class="las la-users"></span>
                    </div>
                </div>


                <div class="card-single">
                    <?php if($_SESSION['admin']===1): ?>
                        <div>
                            <h1><?php echo $numberOfOrders; ?></h1>
                            <span>Orders</span>
                        </div>
                    <?php else:?>
                            <div>
                            <h1><?php echo $getNumberOfInventoryOrderedInDept ?></h1>
                            <span>Orders</span>
                        </div>
                    <?php endif; ?>
                    <div>
                        <span class="las la-clipboard"></span>
                    </div>
                </div>


                <div class="card-single">
                <?php if($_SESSION['admin']===1): ?>
                    <div>
                        <h1><?php echo $CountItemsInProgress?></h1>
                        <span>Orders in progress</span>
                    </div>
                  <?php else:?>
                     <div>
                        <h1><?php echo $getNumberOfInventoryInProgressDept?></h1>
                        <span>Orders in progress</span>
                    </div>
                 <?php endif; ?>
                    <div>
                        <span class="las la-shopping-bag"></span>
                    </div>
                </div>


                <div class="card-single">
                    <div>
                        <h1>The Best</h1>
                        <span>The Best</span>
                    </div>

                    <div>
                        <span class="lab la-google-wallet"></span>
                    </div>
                </div>



            </div>


            <div class="recent-grid">
                <div class="projects">
                    <div class="card">

                        <div class="card-header">
                            <h3>Orders</h3>

                             <?php if($_SESSION['admin'] ===1):?>
                                <a href="<?php echo BASE_URL."/Admin/store/index.php"; ?>">See all <span class="las la-arrow-right"></span></a>
                             <?php endif; ?>

                            
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table width="100%">
                                    <thead>
                                        <tr class="table-header">
                                            <td>Item</td>
                                            <td>Quantity</td>
                                            <td>Status</td>
                                        </tr>
                                    </thead>

                                    <tbody>

                                       <?php if($_SESSION['admin']===2): ?>
                                            <?php foreach($requisitionInDept as $requisition ):?>
                                                <tr>
                                                    <td> <?php echo $requisition['item']; ?> </td>
                                                    <td><?php echo $requisition['quantity']; ?> </td>

                                                    <?php if($requisition['issue']): ?>
                                                        <td><span class="status green"></span>issued</td>

                                                        <?php else: ?>
                                                         <td><span class="status orange"></span>In progress</td>

                                                    <?php endif; ?>

                                                </tr>
                                             <?php endforeach; ?>
                                        <?php else: ?>
                                            <?php foreach($requisitions as $requisition ):?>
                                                <tr>
                                                    <td> <?php echo $requisition['item']; ?> </td>
                                                    <td><?php echo $requisition['quantity']; ?> </td>

                                                    <?php if($requisition['issue']): ?>
                                                        <td><span class="status green"></span>issued</td>

                                                        <?php else: ?>
                                                         <td><span class="status orange"></span>In progress</td>

                                                    <?php endif; ?>

                                                </tr>
                                             <?php endforeach; ?>


                                        <?php endif; ?>

                                      

                                    </tbody>

                                </table>

                            </div>
                        </div>
                    </div>
                </div>


                <div class="customers">
                    <div class="card">

                        <div class="card-header">
                            <h3>REMAINIG IN STORE</h3>
                                 <?php if($_SESSION['admin'] ===1):?>
                                    
                                    <a href="<?php echo BASE_URL."/Admin/store/remaining.php"; ?>" >Add Stock <span class="las la-arrow-right"></span></a>
                                 <?php endif; ?>

                        </div>

                        <div class="card-body">
                       
                           <?php foreach($tableStoreItems as $tableStore ): ?>
                             <?php if($tableStore['remaining'] >= 0):?>
                                    <div class="customer">
                                        <div class="info">
                                          
                                                <img src="<?php echo BASE_URL."../assets/images/here.jpg" ?>" width="40px" height="40px" alt="" />

                                                <div>
                                                    <h4><?php echo $tableStore['item']; ?></h4>                                   
                                                    <small> <?php echo  $tableStore['remaining']; ?></small>
                                                </div>

                                        </div>
                                         <div  class="contact">
                                        
                                            <span class="las la-star"></span>
                                            
                                         </div>    
                                    
                                 </div>
                             <?php  endif; ?>     

                            <?php endforeach; ?>

                             <?php foreach($tableStoreItems as $tableStore ): ?>
                             <?php if($tableStore['remaining'] == 0 && $tableStore['issue'] == 0):?>
                                    <div class="customer">
                                        <div class="info">
                                          
                                                <img src="<?php echo BASE_URL."../assets/images/here.jpg" ?>" width="40px" height="40px" alt="" />

                                                <div>
                                                    <h4><?php echo $tableStore['item']; ?></h4>                                   
                                                    <small> <?php echo  $tableStore['total']; ?></small>
                                                </div>

                                        </div>
                                         <div  class="contact">
                                        
                                            <span class="las la-star"></span>
                                            
                                         </div>    
                                    
                                 </div>
                             <?php  endif; ?>     

                            <?php endforeach; ?>
                        

                        </div>


                    </div>


                </div>

                </div>
        </main>
    </div>



</body>
</html>