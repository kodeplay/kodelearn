    <div class="r pagecontent">
        <div class="pageTop">
            <div class="pageTitle l">Wall</div>
            <div class="pageDesc r"></div>
            <div class="clear"></div>
        </div><!-- pageTop -->
    
        <div id="feeds">
            <?php if($feeds) {?>
            <?php foreach($feeds as $feed_html){?>
	            <div class="vpad10">
                    <?php echo $feed_html; ?>
                </div>
            <?php }?>
            <?php } else {?>
                <div class="vpad10">
                    No feed
                </div>
            <?php }?>
        </div>
        <div id="edit_event"></div>
    </div>
    
   
    