    <div class="r pagecontent">
        <div class="pageTop">
            <div class="pageTitle l">View Attendance</div>
            <div class="pageDesc r">You can view your attendance in all events here. Select a timeframe and a course to view your attendance.</div>
            <div class="clear"></div>
        </div><!-- pageTop -->
        <div class="pageContent">
            <p class="bm40">
                Show attendance from &nbsp; <input type="text" name="date_from" id="date_from" class="date" value="<?php echo $date_from; ?>"></input> &nbsp; to &nbsp; <input type="text" name="date_to" id="date_to" class="date" value="<?php echo $date_to; ?>"></input>
                <!-- <a class="button" href="#" id="add_users"> Add</a> -->
            </p>
            <p class="vm10">
                <label for="course" class="w20 dib">Select a course </label>
                <select name="course" id="course" class="chzn-select" title="Select a course">
                        <option value="0">All</option>
                    <?php foreach($courses as $key=>$value){?>
                        <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                    <?php } ?>    
                </select> <!-- course -->
            </p>
            
            <div style="height:10px;">
                <p class="tip" style="display:none;" id="loading">Please wait...Loading attendence</p>
            </div>
            <div id="events-ajax"> 
                <?php echo $attendence_list ?>          
            </div>
        </div>
    </div>    
    <div class="clear"></div>
<script type="text/javascript"><!--
$('#course').change(function(){
    test();
    
});

$('#date_from').change(function(){
    test();
    
});

$('#date_to').change(function(){
    test();
    
});

function test(){
	$('#loading').fadeIn();
    var course = $('#course').val();
    var date_from = $('#date_from').val();
    var date_to = $('#date_to').val();
    
    if(date_from){
        $.post(KODELEARN.config.base_url + "attendence/get_attendence_exam_lecture", { "course": course, "date_from": date_from, "date_to": date_to},
        function(data){
           $('#events-ajax').html(data.response);
           $('#loading').fadeOut();                
        }, "json");
    }
}
//--></script>
