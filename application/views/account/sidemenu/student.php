<?php if (isset($avatar_user)) { ?>
    <div class="tac hlcontainer" id="profile_image"><div class="prel"><p class="hoverLinks"><a href="<?php echo $change_img_url; ?>">Change</a></p><img id="sbProfileImg" src="<?php echo $avatar_user; ?>" /></div></div>
    <p class="tac sidebarTitle" id="sbName"><?php echo $user->firstname . ' ' . $user->lastname; ?></p>
    <p class="tac h4" id="sbType"><?php echo $role; ?></p>
<?php } ?>
