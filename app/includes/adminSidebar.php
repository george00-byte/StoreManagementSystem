  <div class="left-sidebar">
            <ul>
                 <li><a href="<?php echo BASE_URL."/Admin/dashboard.php"  ?>"> Dashboard</a></li>
                 <?php if($_SESSION['admin']=== 2): ?>
                         <li><a href="<?php echo BASE_URL."/Admin/inventory/index.php"  ?>">Manage Requisitions</a></li>
                  <?php endif; ?>
                   <?php if($_SESSION['admin']=== 1): ?>
                         <li><a href="<?php echo BASE_URL."/Admin/users/index.php"  ?>" >Manage Users</a></li>
                         <li><a href="<?php echo BASE_URL."/Admin/store/index.php"  ?>">Store</a></li>
                         <li><a href="<?php echo BASE_URL."/Admin/store/department.php"  ?>">Departments</a></li>
                    <?php endif; ?>

            </ul>
</div>