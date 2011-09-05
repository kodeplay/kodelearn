	<div class="r pagecontent">
		<div class="pageTop">
			<div class="pageTitle l">replace_here_page_title</div>
			<div class="pageDesc r">replace_here_page_description</div>
			<div class="clear"></div>
		</div><!-- pageTop -->		
		<div class="topbar">
			<?php if (Acl::instance()->is_allowed('batch_delete')){?>
			<a onclick="$('#batch').submit();" class="pageAction r alert">Delete selected...</a>
			<?php }?>
			<?php //echo $links['add_batch']?>
			<?php if (Acl::instance()->is_allowed('batch_create')) { ?>
            <?php echo $links['add_batch']; ?>
            <?php } ?>
			<!-- <a href="#" class="pageAction l">Send message</a> -->
			<span class="clear">&nbsp;</span>
		</div><!-- topbar -->		
		<?php if ($success) {  ?>
            <div class="formMessages w90">     
            <span class="fmIcon good"></span> <span class="fmText" ><?php echo $success ?></span>
            <span class="clear">&nbsp;</span>
            </div>
        <?php } ?>      		
		<form name="batch" id="batch" method="POST" action="<?php echo $links['delete'] ?>">
		<table class="vm10 datatable fullwidth">
			<?php echo $table['heading'] ?>
			<tr class="filter" >
			     <td><input type="hidden" id="filter_url" value="<?php echo $filter_url ?>" /></td>
			     <td><input type="text" name="filter_name" value="<?php echo $filter_name ?>"  /></td>
			     <td></td>
			     <td valign="middle"><a class="button" id="trigger_filter" href="#">Filter</a></td>
			</tr>
			<?php foreach($table['data'] as $batch){ ?>
			<tr>
				<td><input type="checkbox" name="selected[]" class="selected" value="<?php echo $batch->id ?>" /></td>
				<td><?php echo $batch->name ?></td>
				<td><?php echo $batch->users;  ?></td>
				<td>
					<p><?php if (Acl::instance()->is_allowed('batch_edit')) { 
                        echo Html::anchor('/batch/edit/id/'.$batch->id, 'View/Edit');
                    } ?>
					</p>
				</td>
			</tr>
			<?php  } ?>
            <?php if($count > 0){ ?>
                <tr class="pagination">
                    <td class="tar pagination" colspan="4">
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
<script type="text/javascript"><!--
/*
function disableEnterKey(e)
{
     var key;      
     if(window.event)
          key = window.event.keyCode; //IE
     else
          key = e.which; //firefox      

     return (key != 13);
}
*/
//--></script>
