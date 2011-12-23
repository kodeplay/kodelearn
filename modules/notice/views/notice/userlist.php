<tr>    
    <th><input type="checkbox" onclick="$('input[name=\'selected[]\']').attr('checked', checked);" /></th>
    <th><?php echo __('Name'); ?></th>
    <th><?php echo __('Email'); ?></th>
    <th><?php echo __('Telephone'); ?></th>
</tr>
<?php if ($users) { ?>
    <?php foreach ($users as $user) { ?>
        <tr>
            <td><input type="checkbox" name="selected[]" value="<?php echo $user->id; ?>" /></td>
            <td><?php echo $user->fullname(); ?></td>
            <td><?php echo $user->email; ?></td>        
            <td><?php echo __('n/a'); ?></td>
        </tr>
    <?php } ?>
<?php } ?>
