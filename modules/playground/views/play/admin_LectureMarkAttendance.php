<?php include_once 'header.php'; ?>


	<?php include_once 'sidebar.php'; ?>
	
	<div class="r pagecontent">
		<div class="pageTop withBorder">
			<div class="pageTitle l">Mark attendance</div>
			<div class="pageDesc r">You can mark attendance for individual lectures here.</div>
			<div class="clear"></div>
		</div><!-- pageTop -->
		
		<table class="formcontainer bm40">
			<tr>
				<td><label>Lecture</label></td>
				<td class="bold">Algebra (Maths - 8A)</td>
			</tr>
			<tr>
				<td><label for="date">Date</label></td>
				<td><input type="text" id="date" /><span class="icon16 calIcon">&nbsp;</span></td>
			</tr>
			<tr>
				<td><label for="time">Time</label></td>
				<td>
					<select name="" id="time">
						<option value="">Times for lecture and date selected</option>
						<option value="">10 AM to 12 PM</option>
						<option value="">10 AM to 12 PM</option>
					</select>
				</td>
			</tr>
		</table>
		
		<div class="topbar">
			<a href="#" class="pageAction">Select all</a>
			<a href="#" class="pageAction">Deselect all</a>
			<a href="#" class="pageAction">Invert selection</a>
		</div><!-- topbar -->
		
		<table class="datatable">
			<tr>
				<th><input type="checkbox" /></th>
				<th class="w50">Name</th>
				<th>Parents' note</th>
			</tr>
			<tr>
				<td><input type="checkbox" /></td>
				<td>John Appleseed</td>
				<td><a href="#">Request explaination from parents</a></td>
			</tr>
			<tr>
				<td><input type="checkbox" checked="checked" /></td>
				<td>John Doe</td>
				<td>--</td>
			</tr>
			<tr>
				<td><input type="checkbox" /></td>
				<td>Somename Someone</td>
				<td>Somename was absent because he had high fever.</td>
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