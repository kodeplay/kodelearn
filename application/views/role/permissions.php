<div class="r pagecontent">
    <div class="pageTop withBorder">
        <div class="pageTitle l">User roles: <span id="roleOf">Administrators</span></div>
        <div class="pageDesc r">this is a test description this is a test description this is a test description this is a test description this is a test description </div>
        <div class="clear"></div>
    </div><!-- pageTop -->
    <div class="buttons">
        <a class="button" id="allowEverything">Allow All</a>    
        <a class="button" id="denyEverything">Deny All</a>        
        <a class="button saveAcl">Save</a>
        <a class="button">Cancel</a>        
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
