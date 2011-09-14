    <div class="r pagecontent">
        <div class="pageTop">
            <div class="pageTitle l">replace_here_page_title</div>
            <div class="pageDesc r">replace_here_page_description</div>
            <div class="clear"></div>
        </div><!-- pageTop -->
        <div class="topbar">
            <?php if( Acl::instance()->is_allowed('exam_delete')){?>
                <a onclick="$('#exam').submit();" class="pageAction r alert">Delete selected...</a>
            <?php }?> 
            <?php if( Acl::instance()->is_allowed('exam_create')){?>
                <?php echo $links['add']?>
            <?php }?>    
            <?php if(Acl::instance()->has_access('examgroup')){?>
            <?php echo $links['examgroup']?>
            <?php } ?>
            <?php if(Acl::instance()->has_access('examresult')){?>
            <?php echo $links['examresult']?>
            <?php } ?>
            <span class="clear">&nbsp;</span>
        </div><!-- topbar -->
        <?php if ($success) {  ?>
            <div class="formMessages w90">     
            <span class="fmIcon good"></span> <span class="fmText" ><?php echo $success ?></span>
            <span class="clear">&nbsp;</span>
            </div>
        <?php } ?>
        <form name="exam" id="exam" method="POST" action="<?php echo $links['delete'] ?>">
        <div class="vm5" align="right">
            <select id="filter_select" name="filter_select" style="padding:2px; width:150px"> 
              <option value="filter_name">Name</option>
              <option value="filter_grading_period">Grading Period</option>
              <option value="filter_date">Date</option>
              <option value="filter_course">Course</option>
              <option value="filter_total_marks">Total marks</option>
              <option value="filter_passing_marks">Passing marks</option>
              <option value="filter_reminder">Reminder</option>
            </select>
            <input type="text" name="filter" id="filter" value="<?php echo $filter; ?>" style="padding:5px" />
            <a class="button" id="trigger_filter" href="#">Find</a>
            <input type="hidden" id="filter_url" value="<?php echo $filter_url ?>" />
            <input type="hidden" id="select_val" value="<?php echo $filter_select ?>" />
        </div>
        <table class="vm10 datatable fullwidth">
            <?php echo $table['heading']?>
                 
            <?php foreach($table['data'] as $exam){ ?>
            <tr>
                <td><input type="checkbox" class="selected" name="selected[]" value="<?php echo $exam->id ?>" /></td>
                <td><?php echo $exam->name ?></td>
                <td><?php echo $exam->examgroup->name ?></td>
                <td><?php echo date('d M Y h:i A', $exam->event->eventstart) ?></td>
                <td><?php echo $exam->course->name ?></td>
                <td><?php echo $exam->total_marks ?></td>
                <td><?php echo $exam->passing_marks ?></td>
                <td><?php echo ($exam->reminder)?'Yes':'No'; ?></td>
                <td>
                    <p><?php if( Acl::instance()->is_allowed('exam_edit')){?>
                        <?php if($exam->event->eventstart > strtotime(date('d M Y h:i:s A'))) { echo Html::anchor('/exam/edit/id/'.$exam->id, 'View/Edit'); } else { echo "Exam Over"; } ?>
                    <?php }?></p>
                </td>
            </tr>
            <?php }?>
            <?php if($count == 0){ ?>
                <tr>
                    <td colspan="9" align="center">
                        No Records Found
                    </td>
                </tr>
                <?php } ?>
                <tr class="pagination">
                    <td class="tar pagination" colspan="9">
                        <?php echo $pagination ?>
                    </td>
                </tr>
        </table>
        </form>
    </div>
    <div class="clear"></div>

<script type="text/javascript" ><!--

$("#filter_select").change(function () {
    var column = $("#filter_select").val().toLowerCase();
    if (column == 'filter_date') {
        $("#filter").addClass('date');
        $('.date').datepicker({dateFormat: 'yy-mm-dd'});
    } else {
        $('.date').datepicker( "destroy" )
        $("#filter").removeClass('date hasDatepicker');
    }        
})

$(document).ready(function() {
	var column = $("#filter_select").val().toLowerCase();
    if (column == 'filter_date') {
    	$("#filter").addClass('date');
        $('.date').datepicker({dateFormat: 'yy-mm-dd'});
    }
    
});
    
//--></script> 
    
