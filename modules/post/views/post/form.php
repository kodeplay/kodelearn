<div class="clear"></div>
<div class="pad10 tm10" id="post-form">
    <form name="post_status" method="post">
        <textarea name="post" id="post"></textarea>
        <a class="button r">Post</a>
        <div class="clear"></div>
        <div class="vpad10 tm10 hgtfix">
            Share with: &nbsp;
            <select name="post_setting">
                <?php foreach ($visibility_options as $key=>$option) { ?>
                    <option value="<?php echo $key; ?>"><?php echo $option; ?></option>
                <?php } ?>
            </select>&nbsp;
            <?php if ($courses) { ?>
            <select class="hidden" name="course">
                <?php foreach ($courses as $course_id=>$course_name) { ?>
                <option value="<?php echo $course_id; ?>"><?php echo $course_name; ?></option>
                <?php } ?>
            </select>
            <?php } ?>
            <?php if ($batches) { ?>
            <select class="hidden" name="batch">
                <?php foreach ($batches as $batch_id=>$batch_name) { ?>
                <option value="<?php echo $batch_id; ?>"><?php echo $batch_name; ?></option>
                <?php } ?>
            </select>
            <?php } ?>
            <div class="clear"></div>
            <ul class="hidden tm10">
                <?php foreach ($roles as $role_id=>$role_name) { ?>
                    <li><input type="checkbox" name="selected_roles[]" value="<?php echo $role_id; ?>" /><label><?php echo $role_name; ?></label></li>
                <?php } ?>
            </ul>            
        </div>
    </form>     
</div>
<script type="text/javascript">

$(document).ready(function(){
	$("#post").watermark("What are you learning today?");
});

</script>