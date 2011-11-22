	<div class="r pagecontent">
		<div class="pageTop">
			<div class="pageTitle l w60">replace_here_page_title</div>
			<div class="pageDesc r">replace_here_page_description</div>
			<div class="clear"></div>
		</div><!-- pageTop -->
		
		<div class="topbar">
			<?php if( Acl::instance()->is_allowed('location_delete')){?>
			     <a onclick="$('#location').submit();" class="pageAction r alert">Delete selected...</a>
			<?php }?>
			<?php if( Acl::instance()->is_allowed('location_create')){?>
			     <?php echo $links['add_location']?>
			<?php }?>
			<?php if (Acl::instance()->has_access('room')) { ?>
			     <?php echo $links['rooms']?>
			<?php }?>
			<span class="clear">&nbsp;</span>
		</div><!-- topbar -->
		<?php if($msg > 0){?>
            <div class="formMessages"><span class="fmIcon bad"></span> <span class="fmText">Location assigned to some room(s)</span><span class="clear">&nbsp;</span></div>
        <?php }?>
		<form name="location" id="location" class="selection-required" method="POST" action="<?php echo $links['delete'] ?>">
		    <div class="vm5" align="right">
                <select id="filter_select" name="filter_select" style="padding:2px; width:150px"> 
                  <option value="filter_name">Name</option>
                  
                </select>
                <input type="text" name="filter" id="filter" value="<?php echo $filter; ?>" style="padding:5px" />
                <a class="button" id="trigger_filter" href="#">Find</a>
                <input type="hidden" id="filter_url" value="<?php echo $filter_url ?>" />
                <input type="hidden" id="select_val" value="<?php echo $filter_select ?>" />
            </div>
    		<table class="vm10 datatable fullwidth">
    			<?php echo $table['heading'] ?>
    			
    			
    			<?php foreach($table['data'] as $location){ ?>
    					
    			<tr>
    				<?php 
    				    $images = CacheImage::instance();
                        $image = $images->resize($location->image, 200, 100);
    				?>
    				<td><input type="checkbox" name="selected[]" class="selected" value="<?php echo $location->id; ?>" /></td>
    				<td><?php echo $location->name; ?></td>
    				<td><img src="<?php echo $image; ?>" alt="" id="photo" /><?php //echo $location->image;  ?></td>
    				<td><?php echo $location->room_count; ?></td>
    				<td>
    					<p><?php if( Acl::instance()->is_allowed('location_edit')){?>
    					   <?php echo Html::anchor('/location/edit/id/'.$location->id, 'View/Edit')?>
    					   <?php }?>
    					</p>
    				</td>
    			</tr>
    			<?php  } ?>
                <?php if($count == 0){ ?>
                <tr>
                    <td colspan="5" align="center">
                        No Records Found
                    </td>
                </tr>
                <?php } ?>
                <tr class="pagination">
                    <td class="tar pagination" colspan="5">
                        <?php echo $pagination ?>
                    </td>
                </tr>
    		</table>
    	
		
		   
		</form>
		
	</div><!-- content -->
	
	<div class="clear"></div>
<script type="text/javascript">
$(document).ready(function(){
	KODELEARN.modules.get('sidebar').highlight('system');
});
</script>