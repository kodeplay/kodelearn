	<div class="r pagecontent">
		<div class="pageTop">
			<div class="pageTitle l">Users</div>
			<div class="pageDesc r">this is a test description this is a test description this is a test description this is a test description this is a test description </div>
			<div class="clear"></div>
		</div><!-- pageTop -->
		
		<div class="topbar">
			<?php echo $links['add']?>
			<a href="#" class="pageAction l">Send message</a>
			<a href="#" class="pageAction l">Edit</a>
			<a href="#" class="pageAction r alert">Delete selected...</a>
			<span class="clear">&nbsp;</span>
		</div><!-- topbar -->
		
		<table class="vm10 datatable fullwidth">
			<?php echo $table['heading'] ?>
			<?php foreach($users as $user) { ?>
			<tr>
				<td><input class="selected" name="selected" value="<?php echo $user->id ?>" type="checkbox" /></td>
				<td><?php echo $user->id ?></td>
				<td>
					<div class="l w30"><img src="http://placehold.it/56" alt="User" /></div>
					<div class="l">
						<p><?php echo $user->firstname . ' ' . $user->lastname ?></p>
						<p><?php echo $user->email ?></p>
						<p><?php echo $user->roles->find()->name ?></p>
					</div>
					<div class="clear"></div>
				</td>
				<td>
				<?php echo implode(', ', $user->batches->find_all()->as_array(NULL, 'name')); ?>
				</td>
				<td>PHP, JavaScript, ASP</td>
				<td>
					<p><?php echo Html::anchor('/user/edit/id/'.$user->id, 'View/Edit')?></p>
					<p><a href="#">Send message</a></p>
				</td>
			</tr>
			<?php } ?>
            <tr class="pagination">
                <td class="tar pagination" colspan="6">
                    <?php echo $pagination ?>
                </td>
            </tr>
		</table>
		
	</div><!-- content -->
	
	<div class="clear"></div>
