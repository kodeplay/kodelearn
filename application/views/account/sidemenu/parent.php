<?php if (isset($avatar_user)) { ?>
    <div class="tac" id="profile_image"><div class="prel"><a href="<?php echo $change_img_url; ?>" class="fullwidth profileimg_link">Change</a><img id="sbProfileImg" src="<?php echo $avatar_user; ?>" /></div></div>
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