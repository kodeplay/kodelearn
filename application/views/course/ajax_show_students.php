<?php echo $course->name ?> Students

<table class="datatable ">
    <tr>
        <?php foreach($users as $key=>$user){ ?>
        <?php if(($key+1) <= 9){  ?>
        <td class="vpad10 tac">
            <img src="<?php echo $cacheimage->resize($user->avatar, 56, 56);?>" />
            <p><?php echo $user->firstname . ' ' . $user->lastname ?></p>
        </td>
        <?php echo (($key+1) % 3 == 0)?'</tr><tr>':'';?> 
        <?php } else { ?>
            </tr>
            <tr>
                <td colspan=3><?php echo HTML::anchor('course/edit/id/'.$course->id.'#assign-users', 'View More')?> </td>
            </tr>
        <?php break;?>
        <?php } ?>
        <?php } ?>
    </tr>
</table>