<div class="r pagecontent">
    <div class="pageTop withBorder">
        <div class="pageTitle l w60">Your Results for: <?php echo $result->exercise()->title; ?></div>
        <div class="pageDesc r">replace_here_page_description</div>
        <div class="clear"></div>
    </div><!-- pageTop -->    
    
    <div class="tm40">
        <h2 class="h2 hm15"><?php echo __('Score: ') .  $result->score(); ?></h2>        
    </div> 
    <div class="tm30">
        <h3 class="h3 l hm15 tGreen"><?php echo __('Correct Answers: ') .  $result->num_correct(); ?></h3>    
        <h3 class="h3 l tRed"><?php echo __('Incorrect Answers: ') .  $result->num_incorrect(); ?></h3> 
        <div class="clear"></div>       
    </div>   
    <div class="tm30 hm15">
        <h3 class="h3 underline"><?php echo __('Answers Review'); ?></h3>
        <ul>
    </div>      
</div><!-- content -->

<div class="clear"></div>
