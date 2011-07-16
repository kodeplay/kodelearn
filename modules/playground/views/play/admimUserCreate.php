<?php include_once 'header.php'; ?>


	<?php include_once 'sidebar.php'; ?>
	
	<div class="r pagecontent">
		<div class="pageTop withBorder">
			<div class="pageTitle l">Create a new user</div>
			<div class="pageDesc r">Create a new user here.</div>
			<div class="clear"></div>
		</div><!-- pageTop -->
		
		<form action="">
			<table class="formcontainer">
				<tr>
					<td><label for="batch">Select batch</label></td>
					<td>
						<select name="" id="batch">
							<option value="">Standard 8A</option>
							<option value="">Standard 8A</option>
							<option value="">Standard 8A</option>
							<option value="">Standard 8A</option>
							<option value="">Standard 8A</option>
						</select>
					</td>
				</tr>
				<tr>
					<td><label for="course">Select course</label></td>
					<td>
						<select name="" id="course" multiple>
							<option value="">Course 1</option>
							<option value="">Course 1</option>
							<option value="">Course 1</option>
							<option value="">Course 1</option>
						</select>
						<p class="tip">You can select multiple courses.</p>
					</td>
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
					<td><label for="role">Role</label></td>
					<td>
						<select name="" id="role">
							<option value="">Teacher</option>
							<option value="">Parent</option>
							<option value="">Student</option>
						</select>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" class="button" value="Create user" /></td>
				</tr>
			</table>
		</form>
		
	</div><!-- pagecontent -->
	
	<div class="clear"></div>
	

<?php include_once 'footer.php'; ?>