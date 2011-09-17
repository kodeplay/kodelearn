	<div class="r pagecontent">
		<div class="pageTop withBorder">
			<div class="pageTitle l w60">Upload a Document</div>
			<div class="pageDesc r">You can upload a document of type - doc, odt, txt, pdf and images</div>
			<div class="clear"></div>
		</div><!-- pageTop -->
		
		<?php echo $form->startform(); ?>
		<table class="formcontainer bm40">
			<tr>
				<td><?php echo $form->title->label(); ?></td>
				<td><?php echo $form->title->element(); ?><?php echo $form->user_id->element(); ?>
				<span class="form-error"><?php echo $form->title->error(); ?></span></td>
			</tr>
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
				<td></td>
				<td>
					<?php echo $form->save->element(); ?>
				</td>
			</tr>
		</table>
	</div><!-- content -->
	
	<div class="clear"></div>
