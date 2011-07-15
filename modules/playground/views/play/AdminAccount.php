<?php include_once 'header.php'; ?>


	<?php include_once 'sidebar_User.php'; ?>
	
	<div class="r pagecontent">
		<div class="pageTop">
			<div class="pageTitle l">My Account</div>
			<div class="pageDesc r">You can view and edit your account settings here.</div>
			<div class="clear"></div>
		</div><!-- pageTop -->
		
		<div class="topbar">
			<a href="#" class="pageTab active">Profile</a>
			<a href="#" class="pageTab">Privacy</a>
		</div><!-- topbar -->
		
		<form action="">
		<table class="formcontainer vm40">
			<tr>
				<td>Identity number</td>
				<td>A1024</td>
			</tr>
			<tr>
				<td><label for="fname">First name</label></td>
				<td><input type="text" id="fname" /></td>
			</tr>
			<tr>
				<td><label for="lname">Last name</label></td>
				<td><input type="text" id="lname" /></td>
			</tr>
			<tr>
				<td><label for="email">Email</label></td>
				<td><input type="text" id="email" /></td>
			</tr>
			<tr>
				<td>
					<label for="photo">Photograph</label>
					<p class="tip">Preferred size: 100px</p>
				</td>
				<td><img src="http://placehold.it/100" alt="" id="photo" /></td>
			</tr>
			<tr>
				<td><label for="otherd">Other details</label></td>
				<td><textarea name="" id="otherd" cols="30" rows="10"></textarea></td>
			</tr>
			<tr> <!-- shown only for students -->
				<td><label for="batch">Batch</label></td>
				<td>
					Batch One
					<!-- editable only for admins -->
					<select name="" id="" class="hidden">
						<option value="">Batch 1</option>
						<option value="">Batch 1</option>
						<option value="">Batch 1</option>
						<option value="">Batch 1</option>
						<option value="">Batch 1</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<p class="sectionTitle">Change password</p>
				</td>
			</tr>
			<tr>
				<td><label for="pass1">Password</label></td>
				<td><input type="password" id="pass1" /></td>
			</tr>
			<tr>
				<td><label for="pass2">Confirm password</label></td>
				<td><input type="password" id="pass2" /></td>
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