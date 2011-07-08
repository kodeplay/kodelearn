<?php include_once 'header_generic.php'; ?>

			<div class="pageTop withBorder hpad10">
				<div class="w60 pageTitle l">New User</div>
				<div class="w30 pageTitle l">Existing User</div>
			</div><!-- pageTop -->
			
			<div class="vpad40 l" id="suContainer">
				<p class="tdBlue bm40">Sign up and join KodeLearn Learning Management System</p>
				
				<form action="#" method="post">
					<table class="formcontainer">
						<tr>
							<td class="tar">Sign up as a</td>
							<td>
								<select name="suAs" id="suAs">
									<option value="suasStudent">Student</option>
									<option value="suasParent">Parent</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="tar">Your Email</td>
							<td><input type="text" id="email" /></td>
						</tr>
						<tr>
							<td class="tar"><span id="secondaryMailLabel">Parent</span>'s Email</td>
							<td><input type="text" id="secondaryMail" /></td>
						</tr>
						<tr>
							<td class="tar">Your first name</td>
							<td><input type="text" id="fname" /></td>
						</tr>
						<tr>
							<td class="tar">Your last name</td>
							<td><input type="text" id="lname" /></td>
						</tr>
						<tr>
							<td class="tar">Password</td>
							<td><input type="password" id="pass" /></td>
						</tr>
						<tr>
							<td class="tar">Confirm password</td>
							<td><input type="password" id="confpass" /></td>
						</tr>
						<tr>
							<td class="tar">Batch/ Standard</td>
							<td>
								<select name="standard" id="standard">
									<option value="1" id="std1">Standard 1</option>
									<option value="2" id="std2">Standard 2</option>
									<option value="3" id="std3">Standard 3</option>
								</select><!-- standard -->
							</td>
						</tr>
						<tr>
							<td class="tar">Course</td>
							<td>
								<select name="course" id="course">
									<option id="course1">Course 1</option>
									<option id="course2">Course 2</option>
									<option id="course3">Course 3</option>
								</select><!-- course -->
							</td>
						</tr>
						<tr>
							<td class="tar"></td>
							<td><input type="checkbox" id="privacy" name="privacy" /><label for="privacy">I have read and I accept your privacy policy.</label></td>
						</tr>
						<tr>
							<td class="tar"></td>
							<td><input type="submit" class="button" value="Sign up now" /></td>
						</tr>
					</table> <!-- formcontainer -->
				</form>
			</div><!-- suContainer -->
			
			<div class="vpad40 l" id="lContainer">
				<p class="tdBlue bm40">Login to learn online</p>
				<form action="" method="post">
					<table class="formcontainer">
						<tr>
							<td class="tar">Email ID</td>
							<td><input type="text" id="authEmail" /></td>
						</tr>
						<tr>
							<td class="tar">Password</td>
							<td>
								<p><input type="password" id="authPass" /></p>
								<p><a class="tdBlue bold" href="#">Forgot your password?</a></p>
							</td>
						</tr>
						<tr>
							<td class="tar"></td>
							<td><input type="checkbox" id="authRemember" /><label for="authRemember">Remember me on this computer</label></td>
						</tr>
						<tr>
							<td class="tar"></td>
							<td><input type="submit" value="Login" class="button" /></td>
						</tr>
					</table>
				</form>
			</div><!-- lContainer -->
			
			<div class="clear"></div>

<?php include_once 'footer.php'; ?>