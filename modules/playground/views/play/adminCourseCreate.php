<?php include_once 'header.php'; ?>


	<?php include_once 'sidebar_User.php'; ?>
	
	<div class="r pagecontent">
		<div class="pageTop">
			<div class="pageTitle l">Courses</div>
			<div class="pageDesc r">You can view and edit courses here. You can also assign users to courses.</div>
			<div class="clear"></div>
		</div><!-- pageTop -->
		
		<div class="topbar">
			<a href="#" class="pageTab active">Create course</a>
			<a href="#" class="pageTab">Add Users</a>
		</div><!-- topbar -->
		
		<form action="">
		<table class="formcontainer vm40">
			<tr>
				<td><label for="cname">Course name</label></td>
				<td><input type="text" id="cname" /></td>
			</tr>
			<tr>
				<td><label for="batch">Batch</label></td>
				<td>
					<select name="" id="batch">
						<option value="">Batch 1</option>
						<option value="">Batch 1</option>
						<option value="">Batch 1</option>
						<option value="">Batch 1</option>
						<option value="">Batch 1</option>
					</select>
				</td>
			</tr>
			<tr>
				<td><label for="CHANGEME">Instructions <span class="tRed">CHANGE TO DETAILS?</span></label></td>
				<td><textarea name="" id="CHANGEME" cols="30" rows="4"></textarea></td>
			</tr>
			<tr>
				<td><label for="moi">Medium of instructions</label></td>
				<td>
					<select name="" id="moi">
						<option value="">English</option>
						<option value="">French</option>
					</select>
					<p class="tip">Select default language for the course</p>
				</td>
			</tr>
			<tr>
				<td>
					<label for="acode">Access code</label>
				</td>
				<td><input type="text" id="acode" /></td>
			</tr>
			<tr>
				<td><label for="startDt">Course duration</label></td>
				<td>
					<p>Start date </p><p><input type="text" class="datepicker" id="startDt" /><span class="icon16 calIcon">&nbsp;</span></p>
					<p>End date &nbsp; </p><p><input type="text" class="datepicker" /><span class="icon16 calIcon">&nbsp;</span></p>
				</td>
			</tr>
			<tr>
				<td></td>
				<td><input type="submit" class="button" value="Save changes" /></td>
			</tr>
		</table>
		</form>
		
	</div><!-- pagecontent -->
	
	<div class="clear"></div>
	

<?php include_once 'footer.php'; ?>