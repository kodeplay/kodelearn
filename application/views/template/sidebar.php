<div class="sidebar l">
    <?php if ($role === 'Admin') { ?>        
    <p class="sidebarTitle">Administration</p>
    <?php } ?>
    <?php if (isset($avatar)) { 
        ?>
            <?php echo $avatar; ?>
        
	<?php 
	} ?>
    <ul class="lsNone">
        <?php 
          $links = $sidemenu->as_array(); 
          foreach ($links as $link) {
        ?>
              <li class="sidemenu <?php echo $link['title']; ?>"><?php echo $link['html']; ?></li>
        <?php } ?>
    </ul>
</div><!-- sidebar -->
