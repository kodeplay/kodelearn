    <div class="r pagecontent">
        <div class="pageTop">
            <div class="pageTitle l">replace_here_page_title</div>
            <div class="pageDesc r">replace_here_page_description</div>
            <div class="clear"></div>
        </div><!-- pageTop -->        
        
        <div class="topbar">
            <?php if (Acl::instance()->is_allowed('course_delete')) { ?>
            <a onclick="$('#course').submit();" class="pageAction r alert">Delete selected...</a>
            <?php } ?>  
            <?php if (Acl::instance()->is_allowed('course_create')) { ?>
            <?php echo $links['add']; ?>
            <?php } ?>
            <?php if (Acl::instance()->is_allowed('course_join')) { ?>
             &nbsp;&nbsp;<?php echo $links['join']; ?>
            <?php }?>
            <!--  <a href="#" class="pageAction c">Send message</a>-->
            <span class="clear">&nbsp;</span>
        </div><!-- topbar -->
        <?php if ($success) {  ?>
            <div class="formMessages w90">     
            <span class="fmIcon good"></span> <span class="fmText" ><?php echo $success ?></span>
            <span class="clear">&nbsp;</span>
            </div>
        <?php } ?>
        
        
        <form name="course" id="course" method="POST" action="<?php echo $links['delete'] ?>">
        <div class="vm5" align="right">
            <select id="filter_select" name="filter_select" style="padding:2px; width:150px"> 
              <option value="filter_name">Name</option>
              <option value="filter_access_code">Access Code</option>
              <option value="filter_start_date">Start date</option>
              <option value="filter_end_date">End Date</option>
            </select>
            <input type="text" name="filter" id="filter" value="<?php echo $filter; ?>" style="padding:5px" />
            <a class="button" id="trigger_filter" href="#">Find</a>
            <input type="hidden" id="filter_url" value="<?php echo $filter_url ?>" />
            <input type="hidden" id="select_val" value="<?php echo $filter_select ?>" />
        </div>
        <table class="vm10 datatable fullwidth">
            <?php echo $table['heading'] ?>
            <?php foreach($table['data'] as $course){ ?>
            <tr>
                <td><input type="checkbox" class="selected" name="selected[]" value="<?php echo $course->id ?>" /></td>
                <td><?php echo $course->name ?></td>
                <td><?php echo $course->access_code ?></td>
                <td><?php echo $course->start_date ?></td>
                <td><?php echo $course->end_date ?></td>
                <td>
                    <p>
                    <?php echo Html::anchor('/course/summary/id/'.$course->id, 'View')?> 
                    <?php if (Acl::instance()->is_allowed('course_edit')) { 
                        echo '/ ' . Html::anchor('/course/edit/id/'.$course->id, 'Edit');
                    } ?>
                    </p>
                </td>
            </tr>
            <?php }?>
            <?php if($count == 0){ ?>
                <tr>
                    <td colspan="6" align="center">
                        No Records Found
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
    </div><!-- content -->
    
    <div class="clear"></div>
    
<script type="text/javascript" ><!--

$("#filter_select").change(function () {
	var column = $("#filter_select").val().toLowerCase();
    if (column == 'filter_start_date' || column == 'filter_end_date') {
    	$("#filter").addClass('date');
    	$('.date').datepicker({dateFormat: 'yy-mm-dd'});
    } else {
    	$('.date').datepicker( "destroy" )
    	$("#filter").removeClass('date hasDatepicker');
    }        
})

$(document).ready(function() {
    var column = $("#filter_select").val().toLowerCase();
    if (column == 'filter_start_date' || column == 'filter_end_date') {
        $("#filter").addClass('date');
        $('.date').datepicker({dateFormat: 'yy-mm-dd'});
    }
    
});
    
//--></script> 
