<?php include_once 'header.php'; ?>


	<?php include_once 'sidebar_User.php'; ?>
	
	<div class="r pagecontent">
		<div class="pageTop">
			<div class="pageTitle l">View results</div>
			<div class="pageDesc r">You can view the marks that you scored in exams here.</div>
			<div class="clear"></div>
		</div><!-- pageTop -->
		
		<div class="topbar tpad10">
			<select name="" id="examGroup" class="chzn-select" title="Select an Exam Group...">
				<optgroup label="Exam groups">
					<option value="">First Unit Test</option>
					<option value="">First Unit Test Again</option>
					<option value="">First Unit Test Again and Again</option>
				</optgroup>
			</select>
		</div><!-- topbar -->
		
		<table class="datatable vm smallTextBoxes fullwidth">
			<tr>
				<th class="w20">Exam</th>
				<th class="w20">Marks scored</th>
				<th class="w20">Maximum marks</th>
			</tr>
			<tr>
				<td>History</td>
				<td class="alert">22</td>
				<td>100</td>
			</tr>
			<tr>
				<td>English</td>
				<td>53</td>
				<td>100</td>
			</tr>
			<tr>
				<td>English</td>
				<td>53</td>
				<td>100</td>
			</tr>
			<tr>
				<td>English</td>
				<td>53</td>
				<td>100</td>
			</tr>
			<tr>
				<td>English</td>
				<td>53</td>
				<td>100</td>
			</tr>
			<tr>
				<td>English</td>
				<td>53</td>
				<td>100</td>
			</tr>
			<tr>
				<td>English</td>
				<td class="alert">03</td>
				<td>100</td>
			</tr>
			<tr>
				<td>English</td>
				<td>53</td>
				<td>100</td>
			</tr>
			<tr class="pagination">
				<td class="tar pagination" colspan="3">
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