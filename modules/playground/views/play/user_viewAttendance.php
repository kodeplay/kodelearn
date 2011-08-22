<?php include_once 'header.php'; ?>


	<?php include_once 'sidebar_User.php'; ?>
	
	<div class="r pagecontent">
		<div class="pageTop withBorder">
			<div class="pageTitle l">View attendance</div>
			<div class="pageDesc r">You can view your attendance in all events here. Select a timeframe and a course to view your attendance.</div>
			<div class="clear"></div>
		</div><!-- pageTop -->
		
		<div class="vm10 tpad10">
			<p>	<label for="fromDate" class="w20 dib">Show attendance from </label>
				<input type="text" id="fromDate" class="datepicker" />
				<span class="icon16 calIcon dib">&nbsp;</span>
				<label for="toDate">to</label> <input type="text" id="toDate" class="datepicker" />
				<span class="icon16 calIcon dib">&nbsp;</span>
			</p>
			<p class="vm10">
				<label for="course" class="w20 dib">Select a course </label>
				<select name="course" id="course" class="chzn-select" title="Select a course">
					<optgroup label="Courses">
						<option value="">Course 1</option>
						<option value="">Course 2</option>
						<option value="">Course 3</option>
					</optgroup>
				</select> <!-- course -->
			</p>
		</div><!-- vm10 tpad10 -->
		
		<div class="tm40 bold vpad10 tac bdTop bdBottom">Your attendance: <span id="attPerc">&nbsp;</span>%</div>
		<table class="datatable vm smallTextBoxes fullwidth">
			<tr>
				<th class="w20">Date</th>
				<th>Event</th>
				<th>Attendance</th>
			</tr>
			<tr>
				<td>Aug. 31, 2011</td>
				<td>Lecture Name</td>
				<td><span class="attendanceBadge absent">Absent</span></td>
			</tr>
			<tr>
				<td>Aug. 31, 2011</td>
				<td>Lecture Name</td>
				<td><span class="attendanceBadge present">Present</span></td>
			</tr>
			<tr>
				<td>Aug. 31, 2011</td>
				<td>Lecture Name</td>
				<td><span class="attendanceBadge absent">Absent</span></td>
			</tr>
			<tr>
				<td>Aug. 31, 2011</td>
				<td>Lecture Name</td>
				<td><span class="attendanceBadge present">Present</span></td>
			</tr>
			<tr>
				<td>Aug. 31, 2011</td>
				<td>Lecture Name</td>
				<td><span class="attendanceBadge present">Present</span></td>
			</tr>
			<tr>
				<td>Aug. 31, 2011</td>
				<td>Lecture Name</td>
				<td><span class="attendanceBadge present">Present</span></td>
			</tr>
			<tr>
				<td>Aug. 31, 2011</td>
				<td>Lecture Name</td>
				<td><span class="attendanceBadge present">Present</span></td>
			</tr>
			<tr>
				<td>Aug. 31, 2011</td>
				<td>Lecture Name</td>
				<td><span class="attendanceBadge present">Present</span></td>
			</tr>
			<tr>
				<td>Aug. 31, 2011</td>
				<td>Lecture Name</td>
				<td><span class="attendanceBadge present">Present</span></td>
			</tr>
			<tr>
				<td>Aug. 31, 2011</td>
				<td>Lecture Name</td>
				<td><span class="attendanceBadge present">Present</span></td>
			</tr>
			<tr class="pagination">
				<td class="tar pagination" colspan="99">
					<a href="#">&laquo;</a>
					<a href="#">1</a>
					<a href="#" class="selected">2</a>
					<a href="#">3</a>
					<a href="#">&raquo;</a>
				</td>
			</tr>
		</table>

	</div><!-- pagecontent -->
	
	<div class="clear"></div>
	

<?php include_once 'footer.php'; ?>