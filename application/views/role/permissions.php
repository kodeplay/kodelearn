<div class="r pagecontent">
    <div class="pageTop withBorder">
        <div class="pageTitle l">User roles: <span id="roleOf">Administrators</span></div>
        <div class="pageDesc r">this is a test description this is a test description this is a test description this is a test description this is a test description </div>
        <div class="clear"></div>
    </div><!-- pageTop -->
    
    <table class="vm10 datatable fullwidth">
        <tr>
            <th class="w20">Module</th>
            <th>Permissions</th>
            <th class="w15">Save changes</th>
        </tr>
        <?php foreach ($acl as $resource=>$levels) { ?>
        <tr>
            <td><?php echo $resource; ?></td>
            <td>
                <?php foreach ($levels as $level) { ?>
                <div class="roleAction <?php echo $level['permission'] ? 'yes' : 'no'; ?>" id="<?php echo $level['repr_key']; ?>">
                    <?php echo $level['level']; ?><span class="raIcon"></span>
                    <input type="checkbox" name="<?php echo $level['repr_key']; ?>" value="1" <?php echo $level['permission'] ? 'checked="checked"' : ''; ?>/>
                </div>
                <?php } ?>
            </td>
            <td><a href="#">Save</a></td>
        </tr>      
        <?php } ?>  
    </table>

</div><!-- content -->

<div class="clear"></div>
