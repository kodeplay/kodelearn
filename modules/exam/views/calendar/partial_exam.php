<!-- 
  Partial view for day_event of type exam to be shown in the list of day events 
  in calendar 
-->
<li>
   <div class="h3"><?php echo $exam; ?> - [<?php echo $exam->total_marks; ?> marks]</div>        
   <p class="tm5"><?php echo ucfirst($event->eventtype); ?> (<?php echo $examgroup->toLink(); ?>)</p>
   <p class="tm5">Time: <?php echo $timing; ?></p>
   <p class="tm5">Venue: <?php echo $room->toLink(); ?></p>
</li>
