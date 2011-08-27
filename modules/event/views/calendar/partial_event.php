<!-- 
  Fallback Partial view for day_event when no <Type>_Calendar class is found  
  This is to be shown in the list of day events in calendar   
-->
<li>
    <div class="h3"><?php echo ucfirst($event->eventtype); ?></div>        
   <p class="tm5">Time: <?php echo $timing; ?></p>
   <p class="tm5">Venue: <?php echo $room->toLink(); ?></p>
</li>
