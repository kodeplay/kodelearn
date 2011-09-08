<?php if (isset($avatar_user)) { ?>
    <p class="tac"><img id="sbProfileImg" src="<?php echo $avatar_user; ?>" /></p>
    <p class="tac sidebarTitle" id="sbName"><?php echo $user->firstname . ' ' . $user->lastname; ?></p>
    <p class="tac h4" id="sbType"><?php echo $role; ?></p>
<?php } ?>
