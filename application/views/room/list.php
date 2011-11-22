    <div class="r pagecontent">
        <div class="pageTop">
            <div class="pageTitle l w60">replace_here_page_title</div>
            <div class="pageDesc r">replace_here_page_description</div>
            <div class="clear"></div>
        </div><!-- pageTop -->
        
        <div class="topbar">
            <?php if( Acl::instance()->is_allowed('room_delete')){?>
                <a onclick="$('#room').submit();" class="pageAction r alert">Delete selected...</a>
            <?php }?>
            <?php if( Acl::instance()->is_allowed('room_create')){?>
                <?php echo $links['add_room']?>
            <?php }?>    
            <?php if (Acl::instance()->has_access('location')) { ?>
                <?php echo $links['locations']?>
            <?php }?>
            <span class="clear">&nbsp;</span>
        </div><!-- topbar -->
         <?php if($msg > 0){?>
            <div class="formMessages"><span class="fmIcon bad"></span> <span class="fmText">Room assigned to some event(s)</span><span class="clear">&nbsp;</span></div>
        <?php }?>
        <form name="room" id="room" class="selection-required" method="POST" action="<?php echo $links['delete'] ?>">
        <div class="vm5" align="right">
            <select id="filter_select" name="filter_select" style="padding:2px; width:150px"> 
              <option value="filter_room_name">Name</option>
              <option value="filter_number">Number</option>
              <option value="filter_location">Location</option>
            </select>
            <input type="text" name="filter" id="filter" value="<?php echo $filter; ?>" style="padding:5px" />
            <a class="button" id="trigger_filter" href="#">Find</a>
            <input type="hidden" id="filter_url" value="<?php echo $filter_url ?>" />
            <input type="hidden" id="select_val" value="<?php echo $filter_select ?>" />
        </div>
        
        <table class="vm10 datatable fullwidth">
            <?php echo $table['heading'] ?>
            <?php foreach($table['data'] as $room){ ?>
            <tr>
                <td><input type="checkbox" name="selected[]" class="selected" value="<?php echo $room->id ?>" /></td>
                <td><?php echo $room->room_name ?></td>
                <td><?php echo $room->room_number;  ?></td>
                <td><?php echo $room->name;  ?></td>
                <td>
                    <p><?php if( Acl::instance()->is_allowed('room_edit')){?>
                        <?php echo Html::anchor('/room/edit/id/'.$room->id, 'View/Edit')?>
                    <?php }?></p>
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