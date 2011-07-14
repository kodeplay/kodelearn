<?php include_once 'header.php'; ?>


	<?php include_once 'sidebar.php'; ?>
	
	<div class="r pagecontent">
		<div class="pageTop withBorder">
			<div class="pageTitle l">User roles: <span id="roleOf">Administrators</span></div>
			<div class="pageDesc r">this is a test description this is a test description this is a test description this is a test description this is a test description </div>
			<div class="clear"></div>
		</div><!-- pageTop -->
		
		<table class="vm10 datatable fullwidth">
			<tr>
				<th class="w20">Module</th>
				<th>Permissions</th>
				<th class="w15">Save changes</th>
			</tr>
			<tr>
				<td>User</td>
				<td>
					<div class="roleAction yes">Create<span class="raIcon"></span></div>
					<div class="roleAction yes">Edit<span class="raIcon"></span></div>
					<div class="roleAction no">Delete<span class="raIcon"></span></div>
					<div class="roleAction yes">Manage roles<span class="raIcon"></span></div>
				</td>
				<td><a href="#">Save</a></td>
			</tr>
			<tr>
				<td>Exams</td>
				<td>
					<div class="roleAction no">Create<span class="raIcon"></span></div>
					<div class="roleAction no">Edit<span class="raIcon"></span></div>
					<div class="roleAction yes">Upload results<span class="raIcon"></span></div>
				</td>
				<td><a href="#">Save</a></td>
			</tr>
			<tr>
				<td>User</td>
				<td>
					<div class="roleAction yes">Create<span class="raIcon"></span></div>
					<div class="roleAction yes">Edit<span class="raIcon"></span></div>
					<div class="roleAction no">Delete<span class="raIcon"></span></div>
				</td>
				<td><a href="#">Save</a></td>
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