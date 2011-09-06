<div class="r pagecontent">
        <div class="pageTop">
            <div class="pageTitle l"><?php echo $lecture->name; ?></div>
            <div class="pageDesc r">replace_here_page_description</div>
            <div class="clear"></div>
        </div><!-- pageTop -->
        <p class="tip">The row in Red has a conflict in Room. Edit it to remove conflict.</p>
        <table class="vm10 datatable fullwidth">
            <tr>
                <th>Date / Time</th>
                <th>Room</th>
                <?php if ($can_edit) { ?>
                <th>Action</th>
                <?php } ?>
            </tr>
            <?php foreach($events as $event){ ?>
            <tr class="<?php echo (in_array($event->id, $conflict_event_ids)) ? 'tRed':''; ?> <?php echo ($event->cancel)?'tlBrown blBlue':'' ?>">
                <td><p><?php echo date('d M Y, l', $event->eventstart)?></p>
                    <p><?php echo date('h:i a', $event->eventstart)?> to <?php echo date('h:i a', $event->eventend)?> </p></td>
                <td><?php echo $event->room->room_number . ', ' . $event->room->room_name ?></td>
                <?php if ($can_edit) { ?>
                <td>
                    <?php if(!$event->cancel){ ?>
                        <a href="#" onclick="Events.edit(<?php echo $event->id ?>)" >Edit</a>
                    <?php } else {?>
                    Canceled
                    <?php }?>
                </td>
                <?php } ?>
            </tr>
            <?php }?>
        </table>
        <div id="edit_event"></div>
</div>
