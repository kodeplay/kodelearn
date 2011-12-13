<div class="r pagecontent">
    <div class="pageTop">
        <div class="pageTitle l w60">replace_here_page_title</div>
        <div class="pageDesc r">replace_here_page_description</div>
        <div class="clear"></div>
    </div><!-- pageTop -->
    <div class="topbar">
        <?php require 'menu.php'; ?>      
    </div><!-- topbar -->
    <?php if ($success) {  ?>
        <div class="formMessages w90">     
            <span class="fmIcon good"></span> <span class="fmText" ><?php echo $success ?></span>
            <span class="clear">&nbsp;</span>
        </div>
    <?php } ?>
    <div class="buttons">
        <a class="button" onclick="$('#notice-pref-form').submit()"><?php echo __('Save'); ?></a>
        <a class="button"><?php echo __('Cancel'); ?></a>
    </div>
    <form id="notice-pref-form" method="POST" action="<?php echo Url::site('notice/preferences'); ?>">
        <table class="vm10 datatable nonzebra fullwidth">
            <thead>
                <tr>
                    <th>Event</th>
                    <th class="tac">Email<br/><input type="checkbox" class="selectall" /></th>
                    <th class="tac">SMS<br/><input type="checkbox" class="selectall" /></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($notices as $module=>$notice_list) { ?>
                    <tr>
                        <td colspan="3">
                            <h3 class="h3"><?php echo ucfirst($module); ?></h3>
                        </td>
                    </tr>
                    <?php foreach ($notice_list as $event=>$notice) { 
                        $key = $module . '_' . $event;
                    ?>
                    <tr>
                        <td><?php echo $notice['help_text']; ?></td>
                        <td class="tac"><input type="checkbox" name="pref[email][<?php echo $key; ?>]" <?php echo in_array($key, $pref_email) ? 'checked="checked"' : ''; ?>/></td>
                        <td class="tac"><input type="checkbox" name="pref[sms][<?php echo $key; ?>]" <?php echo in_array($key, $pref_sms) ? 'checked="checked"' : ''; ?>/></td>
                    </tr>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </form>
    <div class="buttons">
        <a class="button" onclick="$('#notice-pref-form').submit()"><?php echo __('Save'); ?></a>
        <a class="button"><?php echo __('Cancel'); ?></a>
    </div>
</div><!-- pagecontent -->

<div class="clear"></div>
<script type="text/javascript">
$(document).ready(function () {
    $(".selectall").change(function () {
        var i = $(this).parent().index();
        var checked = $(this).attr('checked');
        $(this).parents('thead').siblings().filter('tbody').children().each(function () {
            $(this).children().eq(i).children().filter("input[type='checkbox']").attr('checked', checked ? 'checked' : false); 
        });
    });
});
</script>
