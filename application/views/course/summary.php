	<div class="r pagecontent">
		<div class="pageTop">
			<div class="pageTitle l w60"><?php echo $course->name ?></div>
			<div class="pageDesc r" title=" <?php echo $course->description ?> "><?php echo Text::limit_chars($course->description, 85) ?>
			<br><br><?php echo date('d M Y', strtotime($course->start_date)) ?> To <?php echo date('d M Y', strtotime($course->end_date)) ?>
			</div>
			
			<div class="clear"></div>
		</div><!-- pageTop -->
		
		
		<div class="topbar vm10">
			<span class="vm5 h1 l"><?php //echo $course->name ?></span>
			<?php if (Acl::instance()->is_allowed('course_edit')) { 
                        echo Html::anchor('/course/edit/id/'.$course->id, 'Edit', array('class' => 'vm5 button r'));
                    } ?>
			
			<span class="clear">&nbsp;</span>
		</div>
		
		<div class="blBrown courseSummary pad10">
			<p class="h2 vm10">Course summary</p>
			<p class="vm10">
				<a href="#"><?php echo $count['count_student']; ?> students</a>
				have access to
				<?php foreach($count['results'] as $results){ 
				        foreach($results as $key=>$value){
				        
				    ?>
				    <a href="#"><?php echo $value. " " .$key; ?></a>
				
				<?php 
				        }
				    }
				?>
				
			</p>
		</div><!-- courseSummary -->
		
		<div id="feeds">
            <?php if(trim($feeds)){ ?>
            <?php echo $feeds ?>
            <?php } else {?>
                <div class="vpad10">
                    No feed
                </div>
            <?php }?>
        </div>
        <?php if(trim($feeds) && ($total_feeds > 5)){ ?>
        <div class="show_more ">
            <a id="more_feeds">show older feeds &#x25BC;</a>
        </div>
        <?php } ?>
		
		
		
		
	</div><!-- pagecontent -->
	<div id="feed_event"></div>
	<div class="clear"></div>
	
 <script type="text/javascript">
 new verticalScroll({
    $link : $('#more_feeds'), 
    action : 'feeds/id/<?php echo $course->id; ?>',
    start : 6,
    controller : 'feed',
    $appendTO: $('#feeds') //Must Be Id  to which you want to append
});
</script>
