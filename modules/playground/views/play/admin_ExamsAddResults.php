<?php include_once 'header.php'; ?>


	<?php include_once 'sidebar.php'; ?>
	
	<div class="r pagecontent">
		<div class="pageTop">
			<div class="pageTitle l">Add results</div>
			<div class="pageDesc r">You can add the marks that students scored in exams here.</div>
			<div class="clear"></div>
		</div><!-- pageTop -->
		
		<div class="topbar tpad10">
			<select name="" id="examGroup" class="chzn-select l" title="Select an Exam Group...">
				<optgroup label="Exam groups">
					<option value="">First Unit Test</option>
					<option value="">First Unit Test Again</option>
					<option value="">First Unit Test Again and Again</option>
				</optgroup>
			</select>
			<a href="#" class="button r">Save changes</a>
			<span class="clear">&nbsp;</span>
		</div><!-- topbar -->
		
		<table class="datatable vm smallTextBoxes fullwidth">
			<tr>
				<th>Student</th>
				<th>English</th>
				<th>Hindi</th>
				<th>Marathi</th>
			</tr>
			<tr>
				<td>John Appleseed</td>
				<td><input type="text" /></td>
				<td><input type="text" /></td>
				<td><input type="text" /></td>
			</tr>
			<tr>
				<td>John Appleseed</td>
				<td><input type="text" /></td>
				<td><input type="text" /></td>
				<td><input type="text" /></td>
			</tr>
			<tr>
				<td>John Appleseed</td>
				<td><input type="text" /></td>
				<td><input type="text" /></td>
				<td><input type="text" /></td>
			</tr>
			<tr>
				<td>John Appleseed</td>
				<td><input type="text" /></td>
				<td><input type="text" /></td>
				<td><input type="text" /></td>
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