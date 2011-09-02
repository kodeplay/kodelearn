    <div class="r pagecontent">
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
    </div>