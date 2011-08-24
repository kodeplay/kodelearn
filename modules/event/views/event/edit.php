<div id="event_from" title="Edit Event">
    <form id="from" name="event">
        <table class="formcontainer bm40">
            <tr>
                <td><?php echo $form->date->label(); ?></td>
                <td><?php echo $form->date->element(); ?></td>
            </tr>
            <tr>
                <td>Room:</td>
                <td></td>
            </tr>
        </table>
    
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
        	        
        	        $( this ).dialog( "close" );
                },
                Cancel: function() {
                    $( this ).dialog( "close" );
                }
            }

        });
    });
</script>
