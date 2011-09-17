    <div class="r pagecontent">
        <div class="pageTop withBorder bm10">
            <div class="pageTitle l w60">replace_here_page_title</div>
            <div class="pageDesc r">replace_here_page_description</div>
            <div class="clear"></div>
        </div><!-- pageTop -->
        <div class="pageContent">
            <p class="bm40">
                <label for="date" class="h5 bold hpad5">Show events of date </label><input type="text" name="date" id="date"  value="<?php echo $date; ?>"></input>
                <!-- <a class="button" href="#" id="add_users"> Add</a> -->
            </p>
	        <?php if ($success) {  ?>
	            <div class="formMessages w90">     
	            <span class="fmIcon good"></span> <span class="fmText" ><?php echo $success ?></span>
	            <span class="clear">&nbsp;</span>
	            </div>
	        <?php } ?>
            <div style="height:10px;">
                <p class="tip" style="display:none;" id="loading">Please wait...Loading Events</p>
            </div>
            <div id="events-ajax"> 
                <?php echo $users ?>          
            </div>
        </div>
    </div>    
    <div class="clear"></div>
<script type="text/javascript"><!--
$(document).ready(function() {
	$( "#date" ).datepicker({ maxDate: +0 });
});

$('#date').change(function(){
	$('#loading').fadeIn();
	
    var date = $('#date').val();
    
    if(date){
        $.post(KODELEARN.config.base_url + "attendance/get_events", { "date": date },
        function(data){
           $('#events-ajax').html(data.response);
           $('#loading').fadeOut();                
        }, "json");
    }
	
});
//--></script>
