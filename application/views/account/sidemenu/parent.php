<?php if (isset($avatar_user)) { ?>
    <p class="tac"><img id="sbProfileImg" src="<?php echo $avatar_user; ?>" /></p>
    <p class="tac sidebarTitle" id="sbName"><?php echo $user->firstname . ' ' . $user->lastname; ?></p>
    <p class="tac h4" id="sbType"><?php echo $role; ?></p>
    <p align="center">
        <?php if($avatar_students){ 
                foreach($avatar_students as $key=>$avatar_student){
                ?>
                    <img class="crsrPoint margin5" src="<?php echo $avatar_student; ?>" title="<?php echo $key; ?>" />
                <?php 
                }
        ?>
    </p>
    <p class="tac h4" id="sbType">Children</p>
    
    
    
<?php 
        } 
    }
?>