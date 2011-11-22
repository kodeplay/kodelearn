<div class="r pagecontent">
	<div class="pageTop withBorder">
		<div class="pageTitle l w60"><?php echo __('Create an Exercise'); ?></div>
		<div class="pageDesc r"><?php echo __('Use questions already in the question bank to create a new Excercise in this course.'); ?></div>
		<div class="clear"></div>
	</div><!-- pageTop -->
	
	<?php echo $form->startform(); ?>

	<div class="vm10">
		<?php echo $form->save->element(); ?>
		<span class="clear h2">&nbsp;</span>
	</div> <!-- vm10 -->
	
	<div id="tabs">
	    <ul>
	        <li><a href="#form-exercise"><?php echo __('Exercise Details'); ?></a></li>
	        <li><a href="#form-questions"><?php echo __('Select Questions'); ?></a></li>
	    </ul>	
	    
	    <?php if ($error_notif) {  ?>
        <div class="formMessages w90">     
            <span class="fmIcon bad"></span> <span class="fmText" ><?php echo $error_notif; ?></span>
            <span class="clear">&nbsp;</span>
        </div>
        <?php } ?>
	    
	    <div id="form-exercise">
	        <table class="formcontainer vm40">
	            <tr>
	                <td class="vatop"><?php echo $form->title->label(); ?></td>
	                <td>
	                    <?php echo $form->title->element(); ?>
	                    <span class="form-error"><?php echo $form->title->error(); ?></span>
	                </td>
	            </tr>
	            <tr>
	                <td class="vatop"><?php echo $form->description->label(); ?></td>
	                <td>
	                    <?php echo $form->description->element(); ?>
	                    <span class="form-error"><?php echo $form->description->error(); ?></span>
	                </td>
	            </tr>
	            <tr>
	                <td class="vatop">
	                    <?php echo $form->format->label(); ?>
	                    <br/>
	                    <ol class="form-assist">
	                        <li>In Quiz format, questions will appear one-by-one and can be answered one at a time</li>
	                        <li>In Test format, all questions will appear together and can be submitted together</li>
	                    </ol>
	                </td>
	                <td><?php echo $form->format->element(); ?></td>
	            </tr>
	            <tr>
	                <td class="vatop"><?php echo $form->pub_status->label(); ?></td>
	                <td><?php echo $form->pub_status->element(); ?></td>
	            </tr>
	            <!-- <tr>
	                <td class="vatop"><?php // echo $form->session_resumable->label(); ?></td>
	                <td><?php //echo $form->session_resumable->element(); ?></td>
	            </tr> -->
	            <tr>
	                <td class="vatop">
	                    <?php echo $form->time_minutes->label(); ?>
	                    <ol class="form-assist">
	                        <li>Leave blank in case the exercise is not timed (unlimited time)</li>
	                    </ol>
	                </td>
	                <td><?php echo $form->time_minutes->element(); ?></td>
	            </tr>	           
	        </table>	    
	    </div>
	    
	    <div id="form-questions">
	        <table class="frame-table">
	            <tr>
	                <th></th>
	                <th class="tal w70"><?php echo __('Question'); ?></th>
	                <th><?php echo __('Marks'); ?></th>
	                <th><?php echo __('Action'); ?></th>
	            </tr>
	            <?php if ($questions) { ?>
	            <?php foreach ($questions as $k=>$question) { ?>
	            <tr class="<?php echo ($k+1)%2 ? 'odd' : 'even'; ?>">
	                <td><input type="checkbox" name="selected[]" value="<?php echo $question->id; ?>" <?php echo in_array($question->id, $selected_questions) ? 'checked="checked"' : ''; ?>/></td>
	                <td><?php echo $question->limit_words(10); ?></td>
	                <td class="tac"><input class="w10" type="text" name="marks[]" disabled="disabled" value="<?php echo isset($exercise_questions[$question->id]) ? $exercise_questions[$question->id] : '' ?>"/></td>
	                <td class="tac"><a href="javascript:void(0);">Preview</a></td>
	            </tr>
	            <?php } ?>
	            <?php } ?>
	        </table>
	    </div>	    
	</div>
	
	<?php echo $form->endForm(); ?>
	
	<br/>
</div><!-- pagecontent -->

<div class="clear"></div>
<script type="text/javascript">
$(document).ready(function () { 
    $( "#tabs" ).tabs({ 'selected': 0 }); 
    
    // allow only numeric values to be entered in the marks input field otherwise show an error
    $("input[name='marks[]']").keyup(function(e) {
        if(isNaN($(this).val())) {
            $(this).val('');
            if (!$("#form-questions").children().filter('.formMessages').length) {
                $("#form-questions").prepend('<div class="formMessages w90"><span class="fmIcon bad"></span><span class="fmText">Please enter numeric values only for marks</span><span class="clear">&nbsp;</span></div>');
            }
        }
    });   
    
    // enable the marks input field when the checkbox for a question is checked
    $("input[name='selected[]']").change(function () {       
        var disable = $(this).attr('checked') == 'checked' ? false : 'disabled',
        bg = $(this).attr('checked') == 'checked' ? '#fff' : '#eee';        
        $(this).parent().siblings().eq(1).children().filter('input').attr('disabled', disable).css('background', bg);       
    }).trigger('change');     
});
</script>
