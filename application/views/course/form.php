	
	<div class="r pagecontent">
		<div class="pageTop">
			<div class="pageTitle l">Courses</div>
			<div class="pageDesc r">You can view and edit courses here. You can also assign users to courses.</div>
			<div class="clear"></div>
		</div><!-- pageTop -->
		
		<div class="topbar">
			<a href="#" class="pageTab active">Create course</a>
			<a href="#" class="pageTab">Assign Users</a>
		</div><!-- topbar -->
		
		<?php echo $form->startform(); ?>
		<table class="formcontainer vm40">
			<tr>
				<td><?php echo $form->name->label(); ?></td>
				<td><?php echo $form->name->element(); ?>
				<span class="form-error"><?php echo $form->name->error(); ?></span></td>
			</tr>
			<tr>
				<td><?php echo $form->description->label(); ?></td>
				<td><?php echo $form->description->element(); ?>
				<span class="form-error"><?php echo $form->description->error(); ?></span></td>
			</tr>
			<tr>
				<td><?php echo $form->access_code->label(); ?></td>
				<td><?php echo $form->access_code->element(); ?>
				<span class="form-error"><?php echo $form->access_code->error(); ?></span></td>
			</tr>
            <tr>
                <td><?php echo $form->start_date->label(); ?></td>
                <td><?php echo $form->start_date->element(); ?>
                <span class="form-error"><?php echo $form->start_date->error(); ?></span></td>
            </tr>
            <tr>
                <td><?php echo $form->end_date->label(); ?></td>
                <td><?php echo $form->end_date->element(); ?>
                <span class="form-error"><?php echo $form->end_date->error(); ?></span></td>
            </tr>
			<tr>
				<td></td>
				<td><?php echo $form->save->element(); ?></td>
			</tr>
		</table>
		<?php echo $form->endForm(); ?>
		
	</div><!-- pagecontent -->
	
	<div class="clear"></div>
	
