<div class="r pagecontent">
    <div style="border-bottom: 1px solid #ccc; padding: 25px 10px; vertical-align: middle; height: 15px;">
        <div class="pageTitle l w60"><?php echo $user->firstname." ".$user->lastname; ?></div>
        <div class="clear"></div>
    </div><!-- pageTop -->
    
    <div style="padding: 10px;">
        <a><?php echo $user->email; ?></a>
    </div>
    <div style="padding: 10px;">
        <?php echo $user->about_me; ?>
    </div>
</div><!-- content -->