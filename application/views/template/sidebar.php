<div class="sidebar l">
    <?php if ($role === 'Admin') { ?>        
    <p class="sidebarTitle">Administration</p>
    <?php } ?>
    <?php if (isset($avatar)) { ?>
    <p class="tac"><img id="sbProfileImg" src="<?php echo $avatar; ?>" /></p>
    <p class="tac sidebarTitle" id="sbName"><?php echo $user->firstname . ' ' . $user->lastname; ?></p>
	<p class="tac h4" id="sbType"><?php echo $role; ?></p>
	<?php } ?>
    <ul class="lsNone">
        <?php 
          $links = $sidemenu->as_array(); 
          foreach ($links as $link) {
        ?>
              <li class="sidemenu"><?php echo $link['html']; ?></li>
        <?php } ?>
    </ul>
</div><!-- sidebar -->
