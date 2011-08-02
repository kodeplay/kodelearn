	
	<div class="r pagecontent">
		<div class="pageTop withBorder">
			<div class="pageTitle l">Courses</div>
			<div class="pageDesc r">You can view and edit courses here. You can also assign users to courses.</div>
			<div class="clear"></div>
		</div><!-- pageTop -->
		
		<?php echo $form->startform(); ?>

		<div class="vm10">
			<?php echo $form->save->element(); ?>
			<span class="clear h2">&nbsp;</span>
		</div> <!-- vm10 -->

		<br/>
		
		<div id="tabs">
		  <ul>
		      <li><a href="#form-details"> Course Details</a></li>
		      <li><a href="#assign-users"> Assign Users</a></li>
		  </ul>
		
		<div id="form-details">
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
				<td></td>
			</tr>
		</table>
		</div>
		
		<div id="assign-users">
			<p class="bm40">
				Add users from Batch: 
				<select id="batch_id">
				  <option value="0">Select Batch</option>
				  <?php foreach($batches as $batch){ ?>
					  <option value="<?php echo $batch->id ?>"><?php echo $batch->name ?></option>
				  <?php }?>
				</select>
				<a class="button" href="#" id="add_users"> Add</a>
			</p>
			
            <?php echo $users ?>		  
		</div>
		</div>
		<?php echo $form->endForm(); ?>
		
	</div><!-- pagecontent -->
	
	<div class="clear"></div>
	
<script type="text/javascript"><!--
KODELEARN.modules.add('assign_users' , (function () {    
    
    return {
        init: function () { 
    	   $( "#tabs" ).tabs();

    	   $('#add_users').click(function(){
        	   var batch_id = $('#batch_id').val();
        	   var course_id = '<?php echo $course_id ?>';
        	   if(batch_id){
                   $.post(KODELEARN.config.base_url + "course/get_users", { "batch_id": batch_id, "course_id": course_id },
                           function(data){
                	       	  $('#assign-users').html(data.response);
                	       	  
                           }, "json");
        	   }
    	   });

        }
    }; 
})());
//--></script>
	