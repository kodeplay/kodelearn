	<div class="r pagecontent">
		<div class="pageTop">
			<div class="pageTitle l">Batches</div>
			<div class="pageDesc r">this is a test description this is a test description this is a test description this is a test description this is a test description </div>
			<div class="clear"></div>
		</div><!-- pageTop -->
		
		<div class="topbar">
			<?php echo $links['add_batch']?>
			<a href="#" class="pageAction l">Send message</a>
			<a onclick="$('#batch').submit();" class="pageAction r alert">Delete selected...</a>
			<span class="clear">&nbsp;</span>
		</div><!-- topbar -->
		
		<p class="vm10 tdBlue bold">
			Search <input type="text" class="search" /> <a class="button" href="#">Go</a>
		</p>
		<form name="batch" id="batch" method="POST" action="<?php echo $links['delete'] ?>">
		<table class="vm10 datatable fullwidth">
			<?php echo $table['heading'] ?>
			<?php foreach($table['data'] as $batch){ ?>
			<tr>
				<td><input type="checkbox" name="selected[]" class="selected" value="<?php echo $batch->id ?>" /></td>
				<td><?php echo $batch->name ?></td>
				<td>50</td>
				<td>
					<p><?php echo Html::anchor('/batch/edit/id/'.$batch->id, 'View/Edit')?></p>
				</td>
			</tr>
			<?php  } ?>
			<tr class="pagination">
				<td class="tar pagination" colspan="4">
					<a href="#">&laquo;</a>
					<a href="#">1</a>
					<a href="#" class="selected">2</a>
					<a href="#">3</a>
					<a href="#">&raquo;</a>
				</td>
			</tr>
		</table>
		</form>
		
	</div><!-- content -->
	
	<div class="clear"></div>
