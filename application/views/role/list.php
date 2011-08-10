<div class="r pagecontent">
    <div class="pageTop withBorder">
        <div class="pageTitle l">User roles</div>
        <div class="pageDesc r"><?php echo $page_description?></div>
        <div class="clear"></div>
    </div><!-- pageTop -->
    
    <table class="vm10 datatable fullwidth">
        <tr>
            <th>&nbsp;</th>
            <th>Role</th>
            <th>No. of Users</th>
            <th>Actions</th>
        </tr>
        <?php if ($roles) { ?>
        <?php foreach ($roles as $role) { ?>
        <tr>
            <td>&nbsp;</td>
            <td><?php echo $role['name']; ?></td>
            <td><?php echo $role['num_users']; ?></td>
            <td>
                <p><?php echo $role['action_edit']; ?></p>
                <p><?php echo $role['action_permissions']; ?></p>
                <p><?php if($role['num_users'] < 1){echo $role['action_delete'];} ?></p>
            </td>
        </tr>
        <?php } ?>
        <?php } ?>        
    </table>

</div><!-- content -->

<div class="clear"></div>
