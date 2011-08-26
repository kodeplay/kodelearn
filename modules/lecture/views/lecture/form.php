    <div class="r pagecontent">
        <div class="pageTop withBorder">
            <div class="pageTitle l">replace_here_page_title</div>
            <div class="pageDesc r">replace_here_page_description</div>
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
                <td><?php echo $form->course_id->label(); ?></td>
                <td><?php echo $form->course_id->element(); ?>
                <span class="form-error"><?php echo $form->course_id->error(); ?></span></td>
            </tr>            
            <tr>
                <td><?php echo $form->user_id->label(); ?></td>
                <td><?php echo $form->user_id->element(); ?>
                <span class="form-error"><?php echo $form->user_id->error(); ?></span></td>
            </tr>
            <tr>
                <td><?php echo $form->room_id->label(); ?></td>
                <td><?php echo $form->room_id->element(); ?>
                <span class="form-error"><?php echo $form->room_id->error(); ?></span></td>
            </tr>
            <tr>
                <td valign="top"><label for="type">Type</label></td>
                <td width="500">
                    <input type="radio" name="type" value="once" <?php echo ($form->get_value('type') == 'once')?'checked="checked"':''?> />Once <input type="radio" name="type" value="repeat" <?php echo ($form->get_value('type') == 'repeat')?'checked="checked"':''?> /> Repeat
                    <div id="once" class="vm10 hidden typedetails">
                        <?php echo $form->once_date->label(); ?> <?php echo $form->once_date->element(); ?><br/>
                        <span class="form-error"><?php echo $form->once_date->error(); ?></span>
                        <input type="hidden" name="once[from]" id="once_slider_from"/>
                        <input type="hidden" name="once[to]" id="once_slider_to"/><br/><br/>
                        <span id="once_slider_time"></span><br/><br/>
                        <div style="width:250px;" id="once_slider"></div>
                    </div>
                    <div id="repeat" class="vm10 typedetails hidden">
                        <?php echo $form->repeat_from->label(); ?> <?php echo $form->repeat_from->element(); ?>
                        <?php echo $form->repeat_to->label(); ?> <?php echo $form->repeat_to->element(); ?>
                        <br/><span class="form-error"><?php echo $form->repeat_from->error(); ?></span>
                        <span class="form-error"><?php echo $form->repeat_to->error(); ?></span>
                          
                        <table class="fullwidth datatable">
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="days[Monday]" <?php echo (isset($days['Monday'])) ? 'checked="checked"' : ''?> /></td>
                                <td>Monday</td>
                                <td><input type="hidden" name="monday[from]" id="monday_slider_from"/>
                                    <input type="hidden" name="monday[to]" id="monday_slider_to"/>
                                    <span id="monday_slider_time"></span>
                                    <div id="monday_slider"></div></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="days[Tuesday]" <?php echo (isset($days['Tuesday'])) ? 'checked="checked"' : ''?> /></td>
                                <td>Tuesday</td>
                                <td><input type="hidden" name="tuesday[from]" id="tuesday_slider_from"/>
                                    <input type="hidden" name="tuesday[to]" id="tuesday_slider_to"/>
                                    <span id="tuesday_slider_time"></span>
                                    <div id="tuesday_slider"></div></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="days[Wednesday]" <?php echo (isset($days['Wednesday'])) ? 'checked="checked"' : ''?> /></td>
                                <td>Wednesday</td>
                                <td><input type="hidden" name="wednesday[from]" id="wednesday_slider_from"/>
                                    <input type="hidden" name="wednesday[to]" id="wednesday_slider_to"/>
                                    <span id="wednesday_slider_time"></span>
                                    <div id="wednesday_slider"></div></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="days[Thursday]" <?php echo (isset($days['Thursday'])) ? 'checked="checked"' : ''?> /></td>
                                <td>Thursday</td>
                                <td><input type="hidden" name="thursday[from]" id="thursday_slider_from"/>
                                    <input type="hidden" name="thursday[to]" id="thursday_slider_to"/>
                                    <span id="thursday_slider_time"></span>
                                    <div id="thursday_slider"></div></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="days[Friday]" <?php echo (isset($days['Friday'])) ? 'checked="checked"' : ''?> /></td>
                                <td>Friday</td>
                                <td><input type="hidden" name="friday[from]" id="friday_slider_from"/>
                                    <input type="hidden" name="friday[to]" id="friday_slider_to"/>
                                    <span id="friday_slider_time"></span>
                                    <div id="friday_slider"></div></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="days[Saturday]" <?php echo (isset($days['Saturday'])) ? 'checked="checked"' : ''?> /></td>
                                <td>Saturday</td>
                                <td><input type="hidden" name="saturday[from]" id="saturday_slider_from"/>
                                    <input type="hidden" name="saturday[to]" id="saturday_slider_to"/>
                                    <span id="saturday_slider_time"></span>
                                    <div id="saturday_slider"></div></td>
                            </tr>
                            <tr>
                                <td><input type="checkbox" name="days[Sunday]" <?php echo (isset($days['Sunday'])) ? 'checked="checked"' : ''?> /></td>
                                <td>Sunday</td>
                                <td><input type="hidden" name="sunday[from]" id="sunday_slider_from"/>
                                    <input type="hidden" name="sunday[to]" id="sunday_slider_to"/>
                                    <span id="sunday_slider_time"></span>
                                    <div id="sunday_slider"></div></td>
                            </tr>
                        </table>
                        <span class="form-error"><?php echo (isset($errors['days'])) ? $errors['days'] : ''; ?></span>
                    </div>
                
                </td>
            </tr>            
            <tr>
                <td></td>
                <td>
                    <?php echo $form->save->element(); ?>
                </td>
            </tr>
        </table>
        <?php echo $form->endForm(); ?>
        
    </div><!-- content -->
    
    <div class="clear"></div>
<script type="text/javascript"><!--

KODELEARN.modules.add('create_lecture' , (function () {    
    
    return {

        sliders: ['once_slider','monday_slider','tuesday_slider','wednesday_slider','thursday_slider','friday_slider','saturday_slider','sunday_slider'],
        
        init: function () { 
            <?php foreach($slider as $key=>$value){ ?>
        
	            $("#" + "<?php echo $key ?>").slider({
	                range: true,
	                min: 0,
	                max: 1439,
	                step: 10,
	                values: [<?php echo $value['from']?>, <?php echo $value['to']?>],
	                slide: KODELEARN.modules.get('time_slider').slideTime
	            });
            <?php }?>
        
           for(var i = 0; i < this.sliders.length; i++){
        	    var event = {target: document.getElementById(this.sliders[i])};
        	    KODELEARN.modules.get('time_slider').slideTime(event);
           }
           this.showType();
           $('input[name="type"]').click(function(){ KODELEARN.modules.get('create_lecture').showType(); });
        },
        showType: function () {
            var type = $('input[name="type"]:checked').val();
            $('.typedetails').hide();
            $('#' + type).show();
        }
    }; 
})());

//--></script>    