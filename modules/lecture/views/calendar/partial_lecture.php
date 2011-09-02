<!-- 
  Partial view for day_event of type exam to be shown in the list of day events 
  in calendar 
-->
<li>
   <div class="h3"><?php echo $lecture->name; ?></div>
   <p class="tm5"><?php echo $course->toLink() . ' ' . ucfirst($event->eventtype); ?></p>   
   <p class="tm5"><?php echo $teacher; ?></p>   
   <p class="tm5">Time: <?php echo $timing; ?></p>
   <p class="tm5">Venue: <?php echo $room->toLink(); ?></p>
</li>
