<?php include_once 'header.php'; ?>


	<?php include_once 'sidebar_User.php'; ?>
	
	<div class="r pagecontent">
		<div class="pageTop withBorder">
			<div class="pageTitle l">Courses</div>
			<div class="pageDesc r">You can assign courses to users by selecting them from the list of available courses and adding them to the list of  assigned courses.</div>
			<div class="clear"></div>
		</div><!-- pageTop -->
		
		<table class="datatable vm vm40 fullwidth">
			<tr>
				<th class="w20"><input type="checkbox" /></th>
				<th>Courses</th>
				<th class="w20"><a href="#" class="button">Save changes</a></th>
			</tr>
			<tr>
				<td><input type="checkbox" id="c1" checked /><label for="c1"> Assigned</label></td>
				<td>Mathematics</td>
				<td></td>
			</tr>
			<tr>
				<td><input type="checkbox" id="c2" /><label for="c2"> Available</label></td>
				<td>Science</td>
				<td></td>
			</tr>
			<tr>
				<td><input type="checkbox" id="c3" checked /><label for="c3"> Assigned</label></td>
				<td>Computer Science</td>
				<td></td>
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
	</div><!-- content -->
	
	<div class="clear"></div>
	

<?php include_once 'footer.php'; ?>