	<div class="r pagecontent">
		<div class="pageTop">
			<div class="pageTitle l w60">replace_here_page_title</div>
			<div class="pageDesc r">replace_here_page_description</div>
			<div class="clear"></div>
		</div><!-- pageTop -->
		
		<div class="topbar">
			<?php if( Acl::instance()->is_allowed('user_delete')){?>
			     <a onclick="$('#form').submit();" class="pageAction r alert">Delete selected...</a>
			<?php }?>
			<?php if( Acl::instance()->is_allowed('user_create')){?>
			     <?php echo $links['add']?>
			<?php }?>
            <!-- <a href="#" class="pageAction l">Send message</a> -->
            <?php if( Acl::instance()->is_allowed('user_upload_csv')){?>
			     <?php echo $links['uploadcsv']?>
			<?php }?>
			<?php if( Acl::instance()->has_access('role')){?>
                 <?php echo $links['roles']?>
            <?php }?>
			<span class="clear">&nbsp;</span>
		</div><!-- topbar -->
		<?php if ($success) {  ?>
            <div class="formMessages w90">     
            <span class="fmIcon good"></span> <span class="fmText" ><?php echo $success ?></span>
            <span class="clear">&nbsp;</span>
            </div>
        <?php } ?>
        <form name="form" id="form" method="POST" action="<?php echo $links['delete'] ?>">
		<div class="vm5" align="right">
    		<select id="filter_select" name="filter_select" style="padding:2px; width:150px"> 
    		  <option value="filter_id">Roll No</option>
    		  <option value="filter_name">Name</option>
    		  <option value="filter_batch">Batch</option>
    		  <option value="filter_course">Course</option>
    		  <option value="filter_approved">Approval status</option>
    		</select>
    		<input type="text" name="filter" id="filter" value="<?php echo $filter; ?>" style="padding:5px" />
    		<a class="button" id="trigger_filter" href="#">Find</a>
    		<input type="hidden" id="filter_url" value="<?php echo $filter_url ?>" />
    		<input type="hidden" id="select_val" value="<?php echo $filter_select ?>" />
        </div>
		
		<table class="vm10 datatable fullwidth">
			<?php echo $table['heading'] ?>
            <?php foreach($users as $user) { ?>
			<tr>
				<td><input class="selected" name="selected[]" value="<?php echo $user->id ?>" type="checkbox" /></td>
				<td class="tac"><?php echo $user->id ?></td>
				<td>
					<div class="l w20"><img src="<?php echo $cacheimage->resize($user->avatar, 40, 40);?>" alt="User" /></div>
					<div class="l">
						<p title="<?php echo $user->fullname() ?>"><?php echo Text::limit_chars($user->fullname(), 30); ?></p>
						<p title="<?php echo $user->email ?>"><?php echo Text::limit_chars($user->email, 30); ?></p>
						<p><?php echo $user->role(); ?></p>
					</div>
					<div class="clear"></div>
				</td>
				<td>
				<?php echo implode(', ', $user->batches()->as_array(NULL, 'name')); ?>
				</td>
				<td><?php echo implode(', ', $user->courses()->as_array(NULL, 'name')); ?></td>
				<td><?php echo $user->getstatus(); ?></td>
				<td>
					<p>
					   <?php if (Acl::instance()->is_allowed('user_edit')) {?>
				            <?php echo Html::anchor('/user/edit/id/'.$user->id, 'View/Edit'); ?>
				       <?php }?>
				    </p>
					<!-- <p><a href="#">Send message</a></p> -->
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
