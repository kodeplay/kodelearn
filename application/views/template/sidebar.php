<div class="sidebar l">
    
    <?php if (isset($avatar)) { 
        ?>
            <?php echo $avatar; ?>
        
	<?php 
	} ?>
    <ul class="lsNone">
        <?php 
			
         if(Session::instance()->get('course_id')){
         	$links = $coursemenu->as_array();
         } else {
			$links = $sidemenu->as_array(); 
         }
          foreach ($links as $link) {
        ?>
              <li class="sidemenu <?php echo $link['title']; ?>"><?php echo $link['html']; ?></li>
        <?php } ?>
    </ul>
</div><!-- sidebar -->
