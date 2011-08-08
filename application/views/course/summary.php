	<div class="r pagecontent">
		<div class="pageTop">
			<div class="pageTitle l">Course</div>
			<div class="pageDesc r">You can view and edit courses here. You can also assign users to courses.</div>
			<div class="clear"></div>
		</div><!-- pageTop -->
		
		
		<div class="topbar vm10">
			<span class="vm5 h1 l"><?php echo $course->name ?></span>
			<?php echo Html::anchor('/course/edit/id/'.$course->id, 'Edit', array('class' => 'vm5 button r'))?>
			<span class="clear">&nbsp;</span>
		</div>
		
		<div class="blBrown courseSummary pad10">
			<p class="h2 vm10">Course summary</p>
			<p class="vm10">
				<a href="#"><?php echo $count['count_student']; ?> students</a>
				have access to
				<a href="#"><?php echo $count['count_exam']; ?> exam(s)</a>
				
			</p>
		</div><!-- courseSummary -->
		
		<div class="vm40">
			<p class="sectionTitle">Recent course material and news</p>
			<ul class="lsNone feed">
				<li class="feedItem lesson">
					<span class="feedIcon">&nbsp;</span>
					<span class="feedContent">Professor John Doe added a new lesson on "Electromagnetic Waves"</span>
					<span class="clear">&nbsp;</span>
				</li>
				<li class="feedItem deadline">
					<span class="feedIcon">&nbsp;</span>
					<span class="feedContent">Assignment #5 due tomorrow.</span>
					<span class="clear">&nbsp;</span>
				</li>
				<li class="feedItem lesson">
					<span class="feedIcon">&nbsp;</span>
					<span class="feedContent">Professor Johnny Doe added a new lesson on "Sea Waves"</span>
					<span class="clear">&nbsp;</span>
				</li>
			</ul>
		</div>
		
		
		
		
	</div><!-- pagecontent -->
	
	<div class="clear"></div>
