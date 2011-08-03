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
                    
                    &nbsp;&nbsp;
                    <?php echo $form->to->label(); ?>
                    <?php echo $form->to->element(); ?>
                <span class="form-error"><?php echo $form->from->error(); ?></span>
                <span class="form-error"><?php echo $form->to->error(); ?></span>
                </td>
            </tr>
            
            <tr>
                <td><?php echo $form->room_id->label(); ?></td>
                <td><?php echo $form->room_id->element(); ?>
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
    	   $('select[name="room_id"]').click(function(){  $('input[name="to"]').blur(); });
           $('input[name="to"]').blur(function(){
               var data = $('form').serializeArray();
               $.post(KODELEARN.config.base_url + "exam/get_avaliable_rooms",  data,
                       function(data){
                           $('select[name="room_id"]').replaceWith(data.element);
                       }, "json");
           });
        }
    }; 
})());

//--></script>