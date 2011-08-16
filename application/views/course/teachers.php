<table class="vm10 datatable fullwidth">
    <tr>
        <th><input type="checkbox" onclick="$('.selected').attr('checked', this.checked);"></th>        
        <th>Teachers' Details</th> 
        <th>Courses Assigned</th>       
    </tr>
    <?php if($teachers) {      
        foreach($teachers as $user){ ?>
        <tr>
            <td><input type="checkbox" name="selected[]" class="selected" value="<?php echo $user->id ?>" <?php echo (in_array($user->id, $assigned_teachers)) ? 'checked="checked"':''?> /></td>
            <td>
                <div class="l w30"><img src="<?php echo $cacheimage->resize($user->avatar, 56, 56);?>" alt="Teacher" /></div>
                <div class="l">
                    <p><?php echo $user->firstname . ' ' . $user->lastname ?></p>
                    <p><?php echo $user->email ?></p>
                    <p><?php echo $user->roles->find()->name ?></p>
                </div>
                <div class="clear"></div>
            </td>      
            <td><?php echo implode(', ', $user->courses->find_all()->as_array(NULL, 'name')); ?></td>      
        </tr>
    <?php } } else {  ?>
    <tr>
        <td colspan = "5" align="center">
            No Records Found
        </td>
    </tr>   
    <?php }
    ?>
</table>
