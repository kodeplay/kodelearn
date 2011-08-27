<!-- 
  Partial view for day_event of type exam to be shown in the list of day events 
  in calendar 
-->
<li>
   <div class="h3"><?php echo $lecture->name; ?></div>        
   <p class="tm5"><?php echo ucfirst($event->eventtype); ?> (Course: <?php echo $course->toLink(); ?>)</p>
   <p class="tm5">Time: <?php echo $timing; ?></p>
   <p class="tm5">Venue: <?php echo $room->toLink(); ?></p>
</li>
