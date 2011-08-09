	<div class="r pagecontent">
		<div class="pageTop">
			<div class="pageTitle l">Locations</div>
			<div class="pageDesc r">this is a test description this is a test description this is a test description this is a test description this is a test description </div>
			<div class="clear"></div>
		</div><!-- pageTop -->
		
		<div class="topbar">
			<?php echo $links['add_location']?>
			<?php echo $links['rooms']?>
			<a onclick="$('#location').submit();" class="pageAction r alert">Delete selected...</a>
			<span class="clear">&nbsp;</span>
		</div><!-- topbar -->
		
		<form name="location" id="location" method="POST" action="<?php echo $links['delete'] ?>">
		
    		<table class="vm10 datatable fullwidth">
    			<?php echo $table['heading'] ?>
    			<tr class="filter" >
    			     <td><input type="hidden" id="filter_url" value="<?php echo $filter_url ?>" /></td>
    			     <td><input type="text" name="filter_name" value="<?php echo $filter_name ?>" /></td>
    			     <td></td>
    			     <td></td>
    			     <td valign="middle"><a class="button" href="#" id="trigger_filter">Filter</a></td>
    			</tr>
    			
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
    					<p><?php echo Html::anchor('/location/edit/id/'.$location->id, 'View/Edit')?></p>
    				</td>
    			</tr>
    			<?php  } ?>
                <?php if($count > 0){ ?>
                <tr class="pagination">
                    <td class="tar pagination" colspan="5">
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
