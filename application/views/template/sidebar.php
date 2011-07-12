<div class="sidebar l">
    <p class="sidebarTitle">Administration</p>
    <ul class="lsNone">
        <?php 
          $links = $sidemenu->as_array(); 
          foreach ($links as $link) {
        ?>
              <li class="sidemenu"><?php echo $link['html']; ?></li>
        <?php } ?>
    </ul>
</div><!-- sidebar -->