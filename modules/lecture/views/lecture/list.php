    <div class="r pagecontent">
        <div class="pageTop">
            <div class="pageTitle l">replace_here_page_title</div>
            <div class="pageDesc r">replace_here_page_description</div>
            <div class="clear"></div>
        </div><!-- pageTop -->
        <?php if (Acl::instance()->is_allowed('lecture_delete') || Acl::instance()->is_allowed('lecture_create')) { ?>
        <div class="topbar">
             <?php if (Acl::instance()->is_allowed('lecture_delete')) { ?>
             <a onclick="$('#lecture').submit();" class="pageAction r alert">Delete selected...</a>
             <?php } ?>
             <?php if (Acl::instance()->is_allowed('lecture_create')) { 
                echo $links['add'];
             } ?>
            <span class="clear">&nbsp;</span>
        </div><!-- topbar -->
        <?php } ?>
        <form name="lecture" id="lecture" method="POST" action="<?php echo $links['delete'] ?>">
        <table class="vm10 datatable fullwidth">
           <?php echo $table['heading']?>
           <?php foreach($table['data'] as $lecture){ ?>
            <tr>
                <td><input type="checkbox" name="selected[]" value="<?php echo $lecture->id ?>" /></td>
                <td><?php echo $lecture->name ?></td>
                <td><?php echo $lecture->course_name ?></td>
                <td><?php echo $lecture->firstname . ' ' . $lecture->lastname ?></td>
                <td><?php 
                    if($lecture->type == 'once'){
                        echo date('d M Y ', $lecture->start_date) . '<br/>';
                        echo date('h:i A ', $lecture->start_date) . ' - ' . date('h:i A ', $lecture->end_date);  
                    } else {
                        $days = unserialize($lecture->when);
                    ?>
                    <table>
                        <tr>
                            <td><?php echo date('d M Y ', $lecture->start_date) ?></td>
                            <td><?php echo date('d M Y ', $lecture->end_date) ?></td>
                        </tr>
                        <?php foreach($days as $day=>$time){ ?>
                        <?php $timing = explode(':',$time); ?>
                            <tr>
                                <td><?php echo $day ?></td>
                                <td><?php echo date('h:i A', strtotime(date('Y-m-d')) + ($timing[0] * 60)) .  ' to ' . date('h:i A', strtotime(date('Y-m-d')) + ($timing[1] * 60)) ?></td>
                            </tr>
                        <?php }?>
                    </table>
                    <?php }?>
                </td>
                <td>
                    <?php if (Acl::instance()->is_allowed('lecture_edit')) { ?>
                        <p><?php echo Html::anchor('/lecture/edit/id/' . $lecture->id, 'View/Edit')?></p>
                    <?php } ?>
                    <p><?php echo Html::anchor('/lecture/schedule/id/' . $lecture->id, 'Schedule')?></p>
                </td>
            </tr>
           <?php } ?>
            <tr class="pagination">
                <td class="tar pagination" colspan="6">
                    <?php echo $pagination ?>
                </td>
            </tr>
        </table>
        </form>
    </div>
