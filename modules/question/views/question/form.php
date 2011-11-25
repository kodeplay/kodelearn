<div class="r pagecontent">
	<div class="pageTop withBorder">
		<div class="pageTitle l w60">replace_here_page_title</div>
		<div class="pageDesc r">replace_here_page_description</div>
		<div class="clear"></div>
	</div><!-- pageTop -->
	
	<?php echo $form->startform(); ?>

	<div class="vm10">
		<?php echo $form->save->element(); ?>
		<span class="clear h2">&nbsp;</span>
	</div> <!-- vm10 -->
	
	<br/>
	
	<?php if ($error_notif) {  ?>
    <div class="formMessages w90">     
        <span class="fmIcon bad"></span> <span class="fmText" ><?php echo $error_notif; ?></span>
        <span class="clear">&nbsp;</span>
    </div>
    <?php } ?>
	
	<div id="tabs">
	     <ul>
	        <li><a href="#form-question"><?php echo __('Question'); ?></a></li>
	        <li><a href="#form-answers"><?php echo $solution_tab; ?></a></li>
	        <li><a href="#form-hints"><?php echo __('Hints'); ?></a></li>
	    </ul>
	
	    <div id="form-question">
	    <table class="formcontainer vm40">
		    <tr>
			    <td class="vatop"><?php echo $form->question->label(); ?></td>
			    <td>
			        <?php echo $form->question->element(); ?>
			        <span class="form-error"><?php echo $form->question->error(); ?></span>
			    </td>
		    </tr>		
		    <tr>
			    <td class="vatop"><?php echo $form->extra->label(); ?></td>
			    <td>
			        <?php echo $form->extra->element(); ?>
			    </td>
		    </tr>	
		    <tr>
			    <td class="vatop"><?php echo $form->course_id->label(); ?></td>
			    <td>
			        <?php echo $form->course_id->element(); ?>
			    </td>
		    </tr>		    	
	    </table>
	    </div>
	
	    <div id="form-answers">
		    <?php echo $solution_form; ?>
	    </div>
	
	    <div id="form-hints">
		    <?php require 'partial_hint_form.php'; ?>
	    </div>
	<?php echo $form->endForm(); ?>
    </div>	
</div><!-- pagecontent -->
<div class="clear"></div>	

<script type="text/javascript">
$(document).ready(function () {
    var quesEditor = KODELEARN.helpers.editor.mathEditor("textarea[name='question']");
    quesEditor.initialize();    
});

</script>
