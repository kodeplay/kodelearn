<?php include_once 'header.php'; ?>


	<?php include_once 'sidebar.php'; ?>
	
	<div class="r pagecontent">
		<div class="pageTop withBorder">
			<div class="pageTitle l">User roles</div>
			<div class="pageDesc r">this is a test description this is a test description this is a test description this is a test description this is a test description </div>
			<div class="clear"></div>
		</div><!-- pageTop -->
		
		<table class="vm10 datatable fullwidth">
			<tr>
				<th><input type="checkbox" /></th>
				<th>Role</th>
				<th>No. of Users</th>
				<th>Actions</th>
			</tr>
			<tr>
				<td><input type="checkbox" /></td>
				<td>Administrators</td>
				<td>2</td>
				<td>
					<p><a href="#">View/ Edit</a></p>
					<p><a href="#" class="tRed">Delete</a></p>
				</td>
			</tr>
			<tr>
				<td><input type="checkbox" /></td>
				<td>Teachers</td>
				<td>12</td>
				<td>
					<p><a href="#">View/ Edit</a></p>
					<p><a href="#" class="tRed">Delete</a></p>
				</td>
			</tr>
			<tr>
				<td><input type="checkbox" /></td>
				<td>Students</td>
				<td>252</td>
				<td>
					<p><a href="#">View/ Edit</a></p>
					<p><a href="#" class="tRed">Delete</a></p>
				</td>
			</tr>
			<tr>
				<td><input type="checkbox" /></td>
				<td>Parents</td>
				<td>253</td>
				<td>
					<p><a href="#">View/ Edit</a></p>
					<p><a href="#" class="tRed">Delete</a></p>
				</td>
			</tr>
			<tr class="pagination">
				<td class="tar pagination" colspan="6">
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