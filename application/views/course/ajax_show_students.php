<p class="bold vpad10 borderbottom1"><?php echo $course->name ?> Students</p>

<ul>
    <?php foreach($users as $key=>$user){ ?>
    <?php if(($key+1) <= 6){  ?>
    <li class="vamid vm10">
        <img src="<?php echo $cacheimage->resize($user->avatar, 40, 40);?>" />
        <?php echo $user->firstname . ' ' . $user->lastname ?>
    </li>
    <?php } else { ?>
</ul>
        <p class="bold vpad10 borderbottom1 bordertop1"><?php echo HTML::anchor('course/edit/id/'.$course->id.'#assign-students', 'View')?> all <?php echo count($users)?> Students</p>
    <?php break;?>
    <?php } ?>
    <?php } ?>
<?php /*?>
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
*/
?>