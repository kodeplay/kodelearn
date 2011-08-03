<div class="r pagecontent">
    <div class="pageTop">
        <div class="pageTitle l">Exam Results</div>
        <div class="pageDesc r">this is a test description this is a test description this is a test description this is a test description this is a test description </div>
        <div class="clear"></div>
    </div><!-- pageTop -->
    <?php if ($success) {  ?>
    <div class="formMessages">     
        <span class="fmIcon good"></span> <span class="fmText" ><?php echo $success ?></span>
        <span class="clear">&nbsp;</span>
    </div>
    <?php } ?>
    <?php echo $form->startform(); ?>
    <table class="formcontainer">
        <tr>
            <td><?php echo $form->examgroup_id->label(); ?></td>
            <td><?php echo $form->examgroup_id->element(); ?></td>
        </tr>
        <tr>            
            <td colspan="2">
                <a href="javascript:void(0);">Download</a> the csv of students first <br/><br/>
                After filling in all the marks, upload it.
            </td>
        </tr>
        <tr>
            <td><?php echo $form->csv_file->label(); ?></td>
            <td>
                <?php echo $form->csv_file->element(); ?>
                <span class="form-error"><?php echo $form->csv_file->error(); ?></span>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><?php echo $form->upload->element(); ?></td>
        </tr>
    </table>
    </div><!-- pagecontent -->
	
<div class="clear"></div>
</div>
