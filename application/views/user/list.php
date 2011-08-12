	<div class="r pagecontent">
		<div class="pageTop">
			<div class="pageTitle l">Users</div>
			<div class="pageDesc r">this is a test description this is a test description this is a test description this is a test description this is a test description </div>
			<div class="clear"></div>
		</div><!-- pageTop -->
		
		<div class="topbar">
			<a onclick="$('#form').submit();" class="pageAction r alert">Delete selected...</a>
			<?php echo $links['add']?>
            <a href="#" class="pageAction l">Send message</a>
            <?php echo $links['uploadcsv']?>
            <?php echo $links['roles']?>
			<span class="clear">&nbsp;</span>
		</div><!-- topbar -->
        <form name="form" id="form" method="POST" action="<?php echo $links['delete'] ?>">
		<table class="vm10 datatable fullwidth">
			<?php echo $table['heading'] ?>
            <tr class="filter" >
                 <td><input type="hidden" id="filter_url" value="<?php echo $filter_url ?>" /></td>
                 <td><input type="text" name="filter_id" value="<?php echo $filter_id ?>" style="width: 40px;" /></td>
                 <td><input type="text" name="filter_name" value="<?php echo $filter_name ?>" /></td>
                 <td></td>
                 <td></td>
                 <td valign="middle"><a class="button" id="trigger_filter" href="#">Filter</a></td>
            </tr>
			<?php foreach($users as $user) { ?>
			<tr>
				<td><input class="selected" name="selected[]" value="<?php echo $user->id ?>" type="checkbox" /></td>
				<td class="tac"><?php echo $user->id ?></td>
				<td>
					<div class="l w30"><img src="<?php echo $cacheimage->resize($user->avatar, 56, 56);?>" alt="User" /></div>
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
				<td><?php echo implode(', ', $user->courses->find_all()->as_array(NULL, 'name')); ?></td>
				<td>
					<p><?php echo Html::anchor('/user/edit/id/'.$user->id, 'View/Edit')?></p>
					<p><a href="#">Send message</a></p>
				</td>
			</tr>
			<?php } ?>
            <?php if($count > 0){ ?>
                <tr class="pagination">
                    <td class="tar pagination" colspan="6">
                        <?php echo $pagination ?>
                    </td>
                </tr>
                <?php 
                } else {
                ?>
                <tr>
                    <td colspan="5" align="center">
                        No Records Found
                    </td>
                </tr>
                <?php 
                }
                ?>
		</table>
		</form>
	</div><!-- content -->
	
	<div class="clear"></div>
