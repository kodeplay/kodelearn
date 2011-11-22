<div class="r pagecontent">
    <div class="pageTop withBorder">
        <div class="pageTitle l w60"><?php echo $exercise->title; ?></div>
        <div class="pageDesc r">replace_here_page_description</div>
        <div class="clear"></div>
    </div><!-- pageTop -->    
    
    <div class="tm40" id="exercise-instructions" style="min-height: 80px;">
        <?php echo $exercise->description; ?>
        <br/> <br/> <br/>        
        <a class="button" id="start-exercise">Attempt Questions</a> 
    </div>    
    <!-- quiz or test as per the format -->    
    <?php echo $partial; ?>   
</div><!-- content -->

<div class="clear"></div>

