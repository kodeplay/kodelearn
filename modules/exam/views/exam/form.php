    <div class="r pagecontent">
        <div class="pageTop withBorder">
            <div class="pageTitle l">Create an Exam </div>
            <div class="pageDesc r">this is a test description this is a test description this is a test description this is a test description this is a test description </div>
            <div class="clear"></div>
        </div><!-- pageTop -->
        <?php echo $form->startform(); ?>
        <table class="formcontainer bm40">
            <tr>
                <td><?php echo $form->name->label(); ?></td>
                <td><?php echo $form->name->element(); ?>
                <span class="form-error"><?php echo $form->name->error(); ?></span></td>
            </tr>
            <tr>
                <td><?php echo $form->examgroup_id->label(); ?></td>
                <td><?php echo $form->examgroup_id->element(); ?>
                <span class="form-error"><?php echo $form->examgroup_id->error(); ?></span></td>
            </tr>
            <tr>
                <td><?php echo $form->course_id->label(); ?></td>
                <td><?php echo $form->course_id->element(); ?>
                <span class="form-error"><?php echo $form->course_id->error(); ?></span></td>
            </tr>
            <tr>
                <td><?php echo $form->total_marks->label(); ?></td>
                <td><?php echo $form->total_marks->element(); ?>
                <span class="form-error"><?php echo $form->total_marks->error(); ?></span></td>
            </tr>
            <tr>
                <td><?php echo $form->passing_marks->label(); ?></td>
                <td><?php echo $form->passing_marks->element(); ?>
                <span class="form-error"><?php echo $form->passing_marks->error(); ?></span></td>
            </tr>
            <tr>
                <td><?php echo $form->date->label(); ?></td>
                <td><?php echo $form->date->element(); ?>
                <span class="form-error"><?php echo $form->date->error(); ?></span></td>
            </tr>
            <tr>
                <td><?php echo 'Time' ?></td>
                <td><?php echo $form->from->element(); ?>
                    <?php echo $form->to->element(); ?><br/>
                <span class="form-error"><?php echo $form->from->error(); ?></span>
                <span class="form-error"><?php echo $form->to->error(); ?></span>
                    <span id="time"></span><br/><br/>
                    <div id="slider-range"></div>
                </td>
            </tr>
            
            <tr>
                <td><?php echo $form->room_id->label(); ?></td>

                <td><span id="loading">Please wait... Loading Rooms</span><br/>
                <?php echo $form->room_id->element(); ?> &nbsp; &nbsp; <?php echo $links['rooms']; ?>
                <span class="form-error"><?php echo $form->room_id->error(); ?></span></td>
            </tr>
            <tr>
                <td><?php echo $form->reminder->label();?></td>
                <td><div class="toggleButton">
                        <a href="#" data="1" class="l <?php echo ($form->get_value('reminder'))?'on':''?>">On</a>
                        <a href="#" data="0" class="l <?php echo ($form->get_value('reminder'))?'':'on'?>">Off</a>
                        <?php echo $form->reminder->element();?>
                        <span class="clear"></span>
                    </div>
                </td>
            </tr>
           
            <tr>
                <td></td>
                <td>
                    <input type="hidden" name="event_id" value="<?php echo $event_id ?>" />
                    <?php echo $form->save->element(); ?>
                </td>
            </tr>
        </table>
        <?php echo $form->endForm(); ?>
        
    </div><!-- content -->
    
    <div class="clear"></div>
<script type="text/javascript"><!--
KODELEARN.modules.add('create_exam' , (function () {    
    
    return {
        init: function () { 
           $('input[name="to"]').blur(function(){
               var data = $('form').serializeArray();
               $.post(KODELEARN.config.base_url + "exam/get_avaliable_rooms",  data,
                       function(data){
                           $('select[name="room_id"]').replaceWith(data.element);
                       }, "json");
           });
           $("#slider-range").slider({
               range: true,
               min: 0,
               max: 1439,
               step: 10,
               values: [540, 1020],
               slide: this.slideTime,
               change: this.getRooms
           });
           
        	this.slideTime();
        	this.getRooms();
        },
        slideTime: function (event, ui){
            if(typeof that === 'undefined') that = this;
       	    var minutes0 = parseInt($("#slider-range").slider("values", 0) % 60);
       	    var hours0 = parseInt($("#slider-range").slider("values", 0) / 60 % 24);
       	    var minutes1 = parseInt($("#slider-range").slider("values", 1) % 60);
       	    var hours1 = parseInt($("#slider-range").slider("values", 1) / 60 % 24);
            $('input[name="from"]').val(that.getTime(hours0, minutes0));
            $('input[name="to"]').val(that.getTime(hours1, minutes1));
      	    $("#time").text(that.getTime(hours0, minutes0) + ' - ' + that.getTime(hours1, minutes1));
        	},
        getTime: function (hours, minutes) {
        	    var time = null;
        	    minutes = minutes + "";
        	    if (hours < 12) {
        	        time = "AM";
        	    }
        	    else {
        	        time = "PM";
        	    }
        	    if (hours == 0) {
        	        hours = 12;
        	    }
        	    if (hours > 12) {
        	        hours = hours - 12;
        	    }
        	    if (minutes.length == 1) {
        	        minutes = "0" + minutes;
        	    }
        	    return hours + ":" + minutes + " " + time;
        	},
        getRooms:   function (){
            $('#loading').fadeIn();
            $('select[name="room_id"]').empty();
            var data = $('form').serializeArray();
            $.post(KODELEARN.config.base_url + "exam/get_avaliable_rooms",  data,
                    function(data){
                        $('select[name="room_id"]').replaceWith(data.element);
                        $('#loading').fadeOut();
                    }, "json");
        }
    }; 
})());

//--></script>