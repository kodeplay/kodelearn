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
    <form name="recipients-form">
    <table class="tm30 l w60 pad2p datatable" id="manual-notice-userlist">
        <tr>
            <td colspan="4"><?php echo __('No User Criteria Selected'); ?></td>
        </tr>        
    </table>
    </form>
    <div class="tm30 hm15 r w30 pad2p bOffBrown" id="manual-notice-filter">
        <p class="vm10"> 
            <a class="button" id="btn-create-email"><?php echo __('Create Email'); ?></a>
            <a class="button" id="btn-create-sms"><?php echo __('Create SMS'); ?></a>
        </p>        
        <br class="clear" />        
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
        <p class="tm30 bm10"><a class="button" id="filter-btn"><?php echo __('Filter Users'); ?></a></p>
    </div>
</div><!-- pagecontent -->

<div id="email-dialog" class="hidden">
    <table class="w90 tm30">
        <tr>
            <td class="w30"><label>Subject:</label></td>
            <td><input type="text" class="w90" name="email_subject"/></td>
        </tr>
        <tr><td colspan="2">&nbsp;</td></tr>
        <tr>
            <td style="vertical-align:top">
                <label>Message:</label><br/>
                <span class="help">No need to add salutation such as 'Dear user' or signature to the message body.</span>
            </td>
            <td><textarea class="w90" style="height: 120px;" name="email_message"></textarea></td>
        </tr>
    </table>   
    <br class="clear"/>
    <a class="button r" id="proceed-email"><?php echo __('Send to Selected'); ?></a>
</div>

<div id="sms-dialog" class="hidden">
    <textarea name="sms-message" id="btn-send-sms"></textarea>
    <br class="clear"/><br/>
    <a class="button" onclick="$('#sms-dialog').dialog('close')"><?php echo __('Proceed &raquo;'); ?></a>
</div>

<div class="clear"></div>
