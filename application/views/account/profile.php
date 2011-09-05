	<div class="r pagecontent">
		<div class="pageTop">
			<div class="pageTitle l">replace_here_page_title</div>
			<div class="pageDesc r">replace_here_page_description</div>
			<div class="clear"></div>
		</div><!-- pageTop -->
		
		<div class="topbar">
			<a href="#" class="pageTab active">Profile</a>
			<!-- <a href="#" class="pageTab">Privacy</a> -->
		</div><!-- topbar -->
		
		<?php echo $form->startform(); ?>
		<table class="formcontainer vm40">
			<tr>
				<td>Identity number</td>
				<td><?php echo $user->id ?></td>
			</tr>
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
				    <a href="#" onclick="return removeImage()">[Remove]</a>
				</td>
			</tr>
			<tr>
				<td><?php echo $form->about_me->label(); ?></td>
				<td><?php echo $form->about_me->element(); ?>
				<span class="form-error"><?php echo $form->about_me->error(); ?></span></td>
			</tr>
			<tr>
				<td colspan="2">
					<p class="sectionTitle">Change password</p>
				</td>
			</tr>
			<tr>
				<td><?php echo $form->password->label(); ?></td>
				<td><?php echo $form->password->element(); ?></td>
			</tr>
			<tr>
				<td><?php echo $form->confirm_password->label(); ?></td>
				<td><?php echo $form->confirm_password->element(); ?>
				<span class="form-error"><?php echo $form->confirm_password->error(); ?></span></td>
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
        } else {
           $('#uploadavatar').after('<span class="form-error">' + data.errors.image + '</span>'); 
        }
    }
});

function removeImage() {
    var usrId = "<?php echo $user->id ?>";
    
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
	                }
	            }
	        });
}


//--></script>