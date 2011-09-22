<div id="event_from" title="Edit Event">
    <div id="error_msg"></div>
    <form id="event_form" name="event">
    <div class="l">
        <span id="loading">Please wait... Loading Rooms</span>
        <input type="hidden" name="event_id" value="<?php echo $event->id ?>" />
        <table class="formcontainer bm40">
            <tr>
                <td><?php echo $form->room_id->label(); ?></td>
                <td><?php echo $form->room_id->element(); ?></td>
            </tr>
            <tr>
                <td><?php echo $form->date->label(); ?></td>
                <td><?php echo $form->date->element(); ?></td>
            </tr>
            <tr>
                <td>Time: </td>
                <td><?php echo $form->from->element(); ?>
                    <?php echo $form->to->element(); ?><br/><span id="slider-range_time"></span><br/><br/>
                    <div id="slider-range"></div></td>
            </tr>
            <tr>
                <td><?php echo $form->cancel->label(); ?></td>
                <td><?php echo $form->cancel->element(); ?></td>
            </tr>
        </table>
    </div>
    <?php if($conflict_event){ ?>
        <div class="l tRed">
            Conflict With:<br/>
            <?php echo ucfirst($conflict_event->eventtype) ?>: <?php echo $event_details->name ?> 
            <a href="#" onclick="Events.switchEvent(<?php echo $conflict_event->id ?>)">Edit this instead</a>
        </div>
    <?php } ?>
    </form>
</div>

<script type="text/javascript">
    var eventId = '<?php echo $event->id ?>';
    $(function() {
    	$('.date').datepicker({dateFormat: 'yy-mm-dd'});
    	
        $( "#event_from" ).dialog({
        	resizable: false,
            modal: true,
            buttons: {
                "Save": function() {
        	        
        	        Events.save();
                },
                Cancel: function() {
                    $( this ).dialog( "destroy" );
                    $('#event_from').remove();
                }
            }

        });
        $("#slider-range").slider({
            range: true,
            min: 0,
            max: 1439,
            step: 30,
            values: [<?php echo $slider['start'] ?>, <?php echo $slider['end'] ?>],
            stop: KODELEARN.modules.get('time_slider').slideTime,
            change: KODELEARN.modules.get('rooms').getAvaliableRooms
        });
        var event = {target: document.getElementById('slider-range')};
        KODELEARN.modules.get('time_slider').slideTime(event);
        KODELEARN.modules.get('rooms').getAvaliableRooms();
    });
</script>
