    <div class="r pagecontent">
        <div class="pageTop withBorder">
            <div class="pageTitle l w60">replace_here_page_title</div>
            <div class="pageDesc r">replace_here_page_description</div>
            <div class="clear"></div>
        </div><!-- pageTop -->
        <?php echo $form->startform(); ?>
        <table class="formcontainer bm40" style="width: 60%;">
            <tr>
                <td><?php echo $form->title->label(); ?></td>
                <td><?php echo $form->title->element(); ?>
                <span class="form-error"><?php echo $form->title->error(); ?></span></td>
            </tr>
            <tr>
                <td class="vatop"><?php echo $form->description->label(); ?></td>
                <td><?php echo $form->description->element(); ?>
                <span class="form-error"><?php echo $form->description->error(); ?></span></td>
            </tr>
            <tr>
                <td colspan="2">
                    <p class="sectionTitle"><?php echo __('Add questions to flash card set'); ?></p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <table style="width: 90%;" class="datatable">
                        <tr>
                            <th style="width: 30%;">
                                <input type="checkbox" onclick="toggle(this);" />
                            </th>
                            <th>
                                Question
                            </th>
                        </tr>
                        <?php foreach($questions as $question){ ?>
                        <tr>
                            <td><input type="checkbox" class="question-selected" name="question_selected[]" value="<?php echo $question->id; ?>" <?php if(in_array($question->id, $selected_question)) { echo "checked='checked'"; } ?> /></td>
                            <td><?php echo $question->question; ?></td>
                            
                        </tr>
                        <?php }?>
                    </table>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <?php echo $form->save->element(); ?>
                    <span class="r">
                        <?php echo $links['cancel']?>
                    </span>
                </td>
            </tr>
        </table>
       
        
        
        
         <?php echo $form->endForm(); ?>
        
        
    </div><!-- content -->
    
    <div class="clear"></div>
<script type="text/javascript">
function toggle(self) {
	var val = $(self).attr('checked');
	if(!val) {
		$('.question-selected').removeAttr('checked');
	} else {
		$('.question-selected').attr('checked', val);
	}
}

</script> 