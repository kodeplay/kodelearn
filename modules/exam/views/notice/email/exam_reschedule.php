<p>
Please note that the exam <b>"<?php echo $exam->name; ?>"</b>&nbsp;
has been rescheduled. The new timings are as follows: <br/><br/>

Date: <?php echo $exam->format_scheduled_date(); ?><br/>
Time: <?php echo $exam->format_starttime(); ?> to <?php echo $exam->format_endtime(); ?>.&nbsp;<br/>

Venue: <?php echo $exam->location(); ?><br/><br/>

Sorry for any inconvenience.
</p>
