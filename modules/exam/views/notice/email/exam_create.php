<p>
A new exam <b>"<?php echo $exam->name; ?>"</b> has been scheduled on <?php echo $exam->format_scheduled_date(); ?> 
as a part of the course <?php echo $exam->course->name; ?> for <?php echo $exam->examgroup; ?>. <br/>
The exam is going to be held in <?php echo $exam->location(); ?>&nbsp;
between <?php echo $exam->format_starttime(); ?> to <?php echo $exam->format_endtime(); ?>.&nbsp;<br/>
Please visit <a href="<?php echo Url::site('home'); ?>">Kodelearn</a> for more details and updates. <br/>
</p>

