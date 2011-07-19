<!DOCTYPE html>
<html>
	<head>
		<title>KodeLearn - Design Components</title>
		<link rel="stylesheet" href="/media/css/reset.css" />
		<link rel="stylesheet" href="/media/css/components.css" />
		<link rel="stylesheet" href="/media/css/kodelearn.css" />
	</head>
	<body>
		<div class="container">
			<div class="pageTop">
				<span class="pageTitle l">Page title</span>
				<span class="pageDesc r">A short description of the page appears here, in #415666 color, at 12px, Verdana. It is a summary of things that can be done on the page.</span>
				<span class="clear">&nbsp;</span>
			</div><!-- pageTop -->
			
			
			<div class="topbar vm40">
				<a href="#">Inactive Page Tab</a>
				<a href="#" class="active">Active Page Tab</a>
			</div><!--topbar-->
			
			<p class="sectionTitle">Section title</p>
		
		
			<form action="#" method="post" id="generalForm">
				<a href="#" class="createButton">Create a new examination</a>
				<br /><br />
				<input type="text" class="search" />
				<br /><br />
				<input type="text" id="" />
				<br />
				<br />
				<br />
				<a href="#" class="button">Save</a>
				<br />		
			</form><!-- general form -->
			<br /><br />
			
			<div class="toggleButton">
				<a href="#" class="l on">On</a>
				<a href="#" class="l">Off</a>
				<span class="clear"></span>
			</div>
			
			<br /><br />
			<table class="datatable tac">
				<tr>
					<th class="w20">Room <span class="downsort">&#x25BC;</span></th>
					<th class="w20">Students</th>
					<th class="w20">Area</th>
				</tr>
				<tr>
					<td>Room 1</td>
					<td>50</td>
					<td>Area 2</td>
				</tr>
				<tr>
					<td>Room 1</td>
					<td>50</td>
					<td>Area 2</td>
				</tr>
				<tr>
					<td>Room 1</td>
					<td>50</td>
					<td>Area 2</td>
				</tr>
			</table>
			
			<br />
			<div class="pagination">
				<a href="#">&laquo;</a>
				<a href="#">1</a>
				<a class="selected" href="#">2</a>
				<a href="#">3</a>
				<a href="#">4</a>
				<a href="#">5</a>
				<a href="#">&raquo;</a>
			</div>
		</div><!-- w960 -->
	</body>
</html>