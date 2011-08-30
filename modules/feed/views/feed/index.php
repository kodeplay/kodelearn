    <div class="r pagecontent">
        <div class="pageTop">
            <div class="pageTitle l">Wall</div>
            <div class="pageDesc r"></div>
            <div class="clear"></div>
        </div><!-- pageTop -->
    
        <div id="feeds">
            <?php if($feeds) {?>
            <?php foreach($feeds as $feed_html){?>
            <?php echo $feed_html; ?>
            <?php }?>
            <?php }?>
        </div>
    </div>