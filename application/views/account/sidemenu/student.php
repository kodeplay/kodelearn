<?php if (isset($avatar_user)) { ?>
    <div class="tac" id="profile_image"><div class="prel"><a href="<?php echo $change_img_url; ?>" class="profileimg_link">Change</a><img id="sbProfileImg" src="<?php echo $avatar_user; ?>" /></div></div>
    <p class="tac sidebarTitle" id="sbName"><?php echo $user->firstname . ' ' . $user->lastname; ?></p>
    <p class="tac h4" id="sbType"><?php echo $role; ?></p>
<?php } ?>
