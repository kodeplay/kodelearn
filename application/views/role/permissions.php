<div class="r pagecontent">
    <div class="pageTop withBorder">
        <div class="pageTitle l">User role: <span id="roleOf"><?php echo $role_name; ?></span></div>
        <div class="pageDesc r">this is a test description this is a test description this is a test description this is a test description this is a test description </div>
        <div class="clear"></div>
    </div><!-- pageTop -->
    <div class="buttons">
        <a class="button" id="allowEverything">Allow All</a>    
        <a class="button" id="denyEverything">Deny All</a>        
        <a class="button saveAcl">Save</a>
        <a href="<?php echo $cancel; ?>" class="button">Cancel</a>        
    </div>
    <form name="acl" id="acl-form" method="post" action="<?php echo $action; ?>">
    <table class="vm10 datatable fullwidth">
        <tr>
            <th class="w20">Module</th>
            <th>Permissions</th>
            <th class="w20"></th>
        </tr>
        <?php foreach ($acl as $resource=>$levels) { ?>
        <tr>
            <td><?php echo $resource; ?></td>
            <td>
                <?php foreach ($levels as $level) { ?>
                <div class="roleAction <?php echo $level['permission'] ? 'yes' : 'no'; ?>" id="<?php echo $level['repr_key']; ?>">
                    <?php echo $level['level']; ?><span class="raIcon"></span>
                    <input type="checkbox" name="acl[<?php echo $level['repr_key']; ?>]" value="1" <?php echo $level['permission'] ? 'checked="checked"' : ''; ?>/>
                </div>
                <?php } ?>
            </td>
            <td>
                <a class="allowAll" href="javascript:void(0);">Allow All</a>&nbsp;
                <a class="denyAll" href="javascript:void(0);">Deny All</a>
            </td>
        </tr>      
        <?php } ?>  
    </table>
    <input type="hidden" name="role_id" value="<?php echo $role_id; ?>" />
    </form>
    <div class="buttons">
        <a class="button saveAcl">Save</a>
    </div>
</div><!-- content -->

<div class="clear"></div>
<script type="text/javascript">
KODELEARN.modules.add('acl', (function () {    
    var warn_deny_all = <?php echo (int)$is_current_role; ?>;
    
    return {
        init: function () { 
            // toggle on click
            $(".roleAction").click(function () {                
                if ($(this).hasClass('yes')) {
                    $(this).removeClass('yes').addClass('no');                    
                    $(this).children().filter("input:checkbox").attr('checked', false);
                } else if ($(this).hasClass('no')) {
                    $(this).removeClass('no').addClass('yes');
                    $(this).children().filter("input:checkbox").attr('checked', true);
                }
            });
            // allow all
            $(".allowAll").click(function () {
                $(this).parent().siblings().eq(1).children().filter('div').each(function () {
                    $(this).removeClass('no').addClass('yes');
                    $(this).children().filter("input:checkbox").attr('checked', true);
                });
            });
            // deny all
            $(".denyAll").click(function () {
                $(this).parent().siblings().eq(1).children().filter('div').each(function () {
                    $(this).removeClass('yes').addClass('no');
                    $(this).children().filter("input:checkbox").attr('checked', false);
                });
            });   
            // allow everything
            $("#allowEverything").click(function () { 
                $(".roleAction").each(function () { 
                    $(this).removeClass('no').addClass('yes');
                    $(this).children().filter("input:checkbox").attr('checked', true);
                });
            });
            // deny everything
            // if current role being editted, show warning if the user tries to do this
            $("#denyEverything").click(function () { 
                var goahead = true;
                if (warn_deny_all == 1) {
                    goahead = confirm('You are trying to deny all permissions to your own role. This means that you will not get to access this page in the future. Do you really want to continue ?');                    
                }
                if (goahead) {
                    $(".roleAction").each(function () { 
                        $(this).removeClass('yes').addClass('no');
                        $(this).children().filter("input:checkbox").attr('checked', false);
                    });
                }
            });
            // submit the form on clicking save
            $(".saveAcl").click(function () {
                $("form#acl-form").submit();
            });        
        },
    }
})());
</script>
