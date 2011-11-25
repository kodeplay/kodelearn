<div class="r pagecontent">
    <div class="pageTop withBorder">
        <div class="pageTitle l w60">Your Results for: <?php echo $result->exercise()->title; ?></div>
        <div class="pageDesc r">replace_here_page_description</div>
        <div class="clear"></div>
    </div><!-- pageTop -->
    
    <?php if (isset($attempted_at)) { ?>
    <div class="tm40">
        <h4 class="h4 hm15"><?php echo __('Attempted On: ') .  date('Y-m-d H:i:s', strtotime($attempted_at)); ?></h4>        
    </div> 
    <?php } ?>   
    
    <div class="tm40">
        <h2 class="h2 hm15"><?php echo __('Score: ') .  $result->score() . ' out of ' . $result->total_marks(); ?></h2>        
    </div> 
    <div class="tm30">
        <h3 class="h3 l hm15 tGreen"><?php echo __('Correct Answers: ') .  $result->num_correct(); ?></h3>    
        <h3 class="h3 l tRed"><?php echo __('Incorrect Answers: ') .  $result->num_incorrect(); ?></h3> 
        <div class="clear"></div>       
    </div>   
    <div class="tm30 hm15">
        <h3 class="h3 underline"><?php echo __('Answers Review'); ?></h3>
        <ul id="answer-reviews">        
            <?php foreach ($result->answer_reviews() as $review) { ?>
            <li>
                <h4 class="h4 vpad5 bold">Q. <?php echo $review['question']; ?></h4>
                <p class="vpad5">
                    <?php echo __('Score: '); ?>
                    <?php echo $review['score'] . '/' . $review['total_marks']; ?>
                    <?php echo $review['hints_used'] ? __('(Marks reducted for using hints)') : ''; ?>                    
                </p> 
                <?php echo $review['answer_review']; ?>
            </li>
            <?php } ?>
        </ul>
    </div>      
</div><!-- content -->

<div class="clear"></div>
