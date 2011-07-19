	<div class="r pagecontent">
		<div class="pageTop withBorder">
			<div class="pageTitle l">Create a Location</div>
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
				<td class="vatop"><?php echo $form->image->label(); ?></td>
				<td><?php echo $form->image->element(); ?>
				<span class="form-error"><?php echo $form->image->error(); ?></span></td>
			</tr>
			<tr>
                <td>
                    <label for="photo">Photograph</label>
                    <p class="tip">Preferred size: 100px</p>
                </td>
                <td><img src="<?php echo $avatar ?>" alt="" id="photo" />
                <input style="font-size:12px;" type="button" id="uploadavatar" value="Upload"></td>
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

//--></script>