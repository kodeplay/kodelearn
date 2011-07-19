<div class="r pagecontent">
    <div class="pageTop withBorder">
        <div class="pageTitle l">User roles</div>
        <div class="pageDesc r">this is a test description this is a test description this is a test description this is a test description this is a test description </div>
        <div class="clear"></div>
    </div><!-- pageTop -->
    
    <table class="vm10 datatable fullwidth">
        <tr>
            <th><input type="checkbox" /></th>
            <th>Role</th>
            <th>No. of Users</th>
            <th>Actions</th>
        </tr>
        <?php if ($roles) { ?>
        <?php foreach ($roles as $role) { ?>
        <tr>
            <td><input type="checkbox" /></td>
            <td><?php echo $role['name']; ?></td>
            <td><?php echo $role['num_users']; ?></td>
            <td>
                <p><?php echo $role['action_edit']; ?></p>
                <p><?php echo $role['action_permissions']; ?></p>
                <p><?php echo $role['action_delete']; ?></p>
            </td>
        </tr>
        <?php } ?>
        <?php } ?>        
        <tr class="pagination">
            <td class="tar pagination" colspan="6">
                <a href="#">&laquo;</a>
                <a href="#">1</a>
                <a href="#" class="selected">2</a>
                <a href="#">3</a>
                <a href="#">&raquo;</a>
            </td>
        </tr>
    </table>

</div><!-- content -->

<div class="clear"></div>

