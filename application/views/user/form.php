	<div class="r pagecontent">
		<div class="pageTop withBorder">
			<div class="pageTitle l w90"><?php echo $page_title; ?></div>
			<div class="pageDesc r">replace_here_page_description</div>
			<div class="clear"></div>
		</div><!-- pageTop -->
		
		<?php echo $form->startform(); ?>
			<table class="formcontainer" id="user-form">
				<tr>
					<td><?php echo $form->firstname->label(); ?></td>
					<td><?php echo $form->firstname->element(); ?>
                        <span class="form-error"><?php echo $form->firstname->error(); ?></span></td>
				</tr>
				<tr>
					<td><?php echo $form->lastname->label(); ?></td>
					<td><?php echo $form->lastname->element(); ?>
					    <span class="form-error"><?php echo $form->lastname->error(); ?></span></td>
				</tr>
				<tr>
					<td><?php echo $form->email->label(); ?></td>
					<td><?php echo $form->email->element(); ?>
					    <span class="form-error"><?php echo $form->email->error(); ?></span></td>
				</tr>
				<tr>
                    <td>
                        <label for="photo">Photograph</label>
                        <p class="tip">Preferred size: 100px</p>
                    </td>
                    <td><img src="<?php echo $avatar ?>" alt="" id="photo" />
                        <input style="font-size:12px;" type="button" id="uploadavatar" value="Upload"><br>
                        <a class = "crsrPoint" onclick="return removeImage()">[Remove]</a>
                        <input type="hidden" name="avatar" id="avatar" value="<?php echo $filename; ?>"></input>
                    </td>
                </tr>
				<tr>
					<td><?php echo $form->role_id->label(); ?></td>
					<td><?php echo $form->role_id->element(); ?></td>
				</tr>
                <tr class="hidden" id="batch-list">
                    <td><?php echo $form->batch_id->label(); ?></td>
                    <td>
                        <?php echo $form->batch_id->element(); ?>
                        <p class="tip">You can select multiple batches.</p>
                    </td>
                </tr>                
                <tr class="hidden" id="course-list">
                    <td><?php echo $form->course_id->label(); ?></td>
                    <td><?php echo $form->course_id->element(); ?>
                        <p class="tip">You can select multiple courses.</p>
                    </td>
                </tr>
                <tr>
                    <td><?php echo $form->status->label(); ?></td>
                    <td><?php echo $form->status->element(); ?></td>
                </tr>
				<tr>
					<td></td>
					<td><?php echo $form->save->element(); ?></td>
				</tr>
			</table>
		<?php echo $form->endForm(); ?>
		
	</div><!-- pagecontent -->
	
	<div class="clear"></div>
	
<script type="text/javascript"><!--
new AjaxUpload('#uploadavatar', {
    action : '<?php echo $upload_url ?>',
    name : 'image',
    autoSubmit : true,
    responseType: 'json',
    onChange: function(file, extension){   },   
    onSubmit: function(file, extension) {
        //alert('submiting');
    },
    onComplete: function(file, data) {
        
        if(data.success){
            $('#photo').attr('src',data.image);
            $('#avatar').val(data.filename);
        } else {
           $('#uploadavatar').after('<span class="form-error">' + data.errors.image + '</span>');
        }
    }
});

function removeImage() {
    var usrId = "<?php //echo $user->id ?>";
    
    $.ajax(
            {
                type: "POST",
                dataType:"html",
                url:     "<?php echo $remove_url ?>",
                data:    "usrId="+usrId,
                success: function(data)
                {
                    if(data != ""){
                        $('#photo').attr('src',data);
                        $('#avatar').val('');
                    }
                }
            });
}


//--></script>	
