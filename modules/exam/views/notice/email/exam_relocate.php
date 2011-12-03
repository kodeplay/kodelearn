<p>
Please note that the exam <b>"<?php echo $exam->name; ?>"</b>&nbsp;
to be held on <?php echo $exam->format_scheduled_date(); ?> between <?php echo $exam->format_starttime(); ?> to&nbsp;
<?php echo $exam->format_endtime(); ?> had been changed to <?php echo $exam->location(); ?><br/><br/>

Sorry for any inconvenience.
</p>
