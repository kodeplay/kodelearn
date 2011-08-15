<div class="r pagecontent">

    <div class="pageTop withBorder">
        <div class="pageTitle l">Exam Results</div>
        <div class="pageDesc r">this is a test description this is a test description this is a test description this is a test description this is a test description </div>
        <div class="clear"></div>
    </div><!-- pageTop -->
    <?php if ($success) {  ?>
    <div class="formMessages w90">     
        <span class="fmIcon good"></span> <span class="fmText" ><?php echo $success ?></span>
        <span class="clear">&nbsp;</span>
    </div>
    <?php } ?>
    <?php if ($warning) { ?>
    <div class="formMessages w90">
        <span class="fmIcon bad"></span> 
        <span class="fmText"><?php echo $warning; ?></span>
        <span class="clear">&nbsp;</span>
    </div>
    <?php } ?>    
    <?php echo $form->startform(); ?>
    <table class="formcontainer tm40">
        <tr>
            <td><?php echo $form->examgroup_id->label(); ?></td>
            <td><?php echo $form->examgroup_id->element(); ?></td>
        </tr>
        <tr>            
            <td colspan="2">                
                <a href="#" onclick="downloadurl();">Download</a> the csv of students first <br/><br/>
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
            <td align="center"><?php echo $form->upload->element(); ?></td>
        </tr>
        <tr>
            <td colspan="2" align="center">OR</td>
        </tr>
        <tr>
            <td colspan="2">
                Click <a id="browser-edit" href="javascript:void(0);">here</a> to edit 
                the results in the browser for the above selected examgroup
            </td>
        </tr>
    </table>
    <?php echo $form->endform(); ?>
    </div><!-- pagecontent -->
	
<div class="clear"></div>
</div>
<script type="text/javascript"><!--
function downloadurl()
{
	var examgroup_id = $('#examgroup_id').val();
   
	window.location.href = "<?php echo Url::base(); ?>index.php/examresult/download_csv/examgroup_id/"+examgroup_id;
	
}
$("#browser-edit").click(function() {
    window.location.href = "<?php echo Url::base(); ?>index.php/examresult/edit/examgroup_id/"+$('#examgroup_id').val();
});
//--></script>
