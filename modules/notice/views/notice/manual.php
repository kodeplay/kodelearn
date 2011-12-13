<div class="r pagecontent">
    <div class="pageTop">
        <div class="pageTitle l w60">replace_here_page_title</div>
        <div class="pageDesc r">replace_here_page_description</div>
        <div class="clear"></div>
    </div><!-- pageTop -->
    <div class="topbar">
        <?php require 'menu.php'; ?>
    </div><!-- topbar -->
    <h3 class="h3 tm40">Please select users whom you want to send the notice by selecting at least one criteria on the right.</h3>
    <table class="tm30 l w60 pad2p" id="manual-notice-userlist">
        <tr>
            <td colspan="4"><?php echo __('No User Criteria Selected'); ?></td>
        </tr>        
    </table>
    <div class="tm30 hm15 r w30 pad2p bOffBrown" id="manual-notice-filter">           
        Select Users by:
        <p class="tm10"> 
            <label>Course: </label>
            <?php if ($courses) { ?>
            <select class="tm10" name="course">
                <option value="0"><?php echo __('---- Select Course ----'); ?></option>
                <?php foreach ($courses as $course_id=>$course_name) { ?>
                <option value="<?php echo $course_id; ?>"><?php echo $course_name; ?></option>
                <?php } ?>
            </select>
            <?php } ?>
        </p>
        <p class="tm10"> 
            <label>Batch: </label>
            <?php if ($batches) { ?>
            <select class="tm10" name="batch">
                <option value="0"><?php echo __('---- Select Batch ----'); ?></option>
                <?php foreach ($batches as $batch_id=>$batch_name) { ?>
                <option value="<?php echo $batch_id; ?>"><?php echo $batch_name; ?></option>
                <?php } ?>
            </select>
            <?php } ?>
        </p>
        <h4 class="tm10">Roles</h4>
        <ul class="tm5">
            <?php foreach ($roles as $role_id=>$role) { ?>
            <li>
                <input type="checkbox" name="filter_role[]" id="filter-role-<?php echo $role_id; ?>" value="<?php echo $role_id; ?>" />
                <label for="filter-role-<?php echo $role_id; ?>"><?php echo $role; ?></label>
            </li>
            <?php } ?>
        </ul>        
    </div>
</div><!-- pagecontent -->

<div class="clear"></div>
<script type="text/javascript">
$(document).ready(function () {
    var $rolelist = $("input[name='filter_role']"),
    $course = $("select[name='course']"),
    $batch = $("select[name='batch']");
    $("select[name='course']").change(function () {            
        get_user_list($(this).val(), 0, $rolelist.val());
    });
    $("select[name='batch']").change(function () {
        get_user_list(0, $(this).val(), $rolelist.val());
    });
    $("input[name='filter_role']").change(function () {
        get_user_list($course.val(), $batch.val(), $(this).val());
    });    
    function get_user_list(course, batch, roles) {
        console.log(course, batch, roles);    
    }
});
</script>
