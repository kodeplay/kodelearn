        <table class="vm10 datatable fullwidth">
            <tr>
                <th><input type="checkbox" onclick="$('.selected').attr('checked', this.checked);"></th>
                <th>Roll No.</th>
                <th>Name</th>
                <th>Batch</th>
                <th>Courses</th>
            </tr>
            <?php foreach($data as $user){ ?>
            <tr>
                <td><input type="checkbox" name="selected[]" class="selected" value="<?php echo $user->id ?>" <?php echo (in_array($user->id, $user_ids)) ? 'checked="checked"':''?> /></td>
                <td><?php echo $user->id ?></td>
                <td>
                    <div class="l w30"><img src="<?php echo $cacheimage->resize($user->avatar, 56, 56);?>" alt="User" /></div>
                    <div class="l">
                        <p><?php echo $user->firstname . ' ' . $user->lastname ?></p>
                        <p><?php echo $user->email ?></p>
                        <p><?php echo $user->roles->find()->name ?></p>
                    </div>
                    <div class="clear"></div>
                </td>
                <td><?php echo implode(', ', $user->batches->find_all()->as_array(NULL, 'name')); ?></td>
                <td><?php echo implode(', ', $user->courses->find_all()->as_array(NULL, 'name')); ?></td>
            </tr>
            <?php } ?>
        </table>
