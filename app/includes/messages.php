<?php if(isset($_SESSION['message'])): ?>
    <?php if($_SESSION['message']==0 ||$_SESSION['message']=='4' || $_SESSION['message']=='5'  ): ?>
      
    <?php else:?>
         <div class="msg <?php echo $_SESSION['type']; ?>">
                <li> <?php echo $_SESSION['message']; ?> </li>

                <?php
                    unset($_SESSION['message']);
                    unset($_SESSION['type']);
                ?>
          </div> 
    <?php endif;?>
<?php endif;?>





