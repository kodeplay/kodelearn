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
		
		<form name="batch" id="batch" method="POST" action="<?php echo $links['delete'] ?>">
		<table class="vm10 datatable fullwidth">
			<?php echo $table['heading'] ?>
			<tr class="filter" >
			     <td><input type="hidden" id="filter_url" value="<?php echo $filter_url ?>" /></td>
			     <td><input type="text" name="filter_name" value="<?php echo $filter_name ?>" /></td>
			     <td></td>
			     <td valign="middle"><a class="button" id="trigger_filter" href="#">Filter</a></td>
			</tr>
			<?php foreach($table['data'] as $batch){ ?>
			<tr>
				<td><input type="checkbox" name="selected[]" class="selected" value="<?php echo $batch->id ?>" /></td>
				<td><?php echo $batch->name ?></td>
				<td><?php echo $batch->users;  ?></td>
				<td>
					<p><?php echo Html::anchor('/batch/edit/id/'.$batch->id, 'View/Edit')?></p>
				</td>
			</tr>
			<?php  } ?>
            <tr class="pagination">
                <td class="tar pagination" colspan="4">
                    <?php echo $pagination ?>
                </td>
            </tr>
		</table>
		</form>
		
	</div><!-- content -->
	
	<div class="clear"></div>
