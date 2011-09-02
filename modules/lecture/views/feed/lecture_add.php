<?php 
    $image = CacheImage::instance();
    $avatar = $image->resize($user->avatar, 50, 50);
?>

    
    <table class="fullwidth">
        <tr>
            <td class="w8">
                <img src = "<?php echo $avatar; ?>"></img>
            </td>
            <td class="vatop">
                <p class="h3"><?php echo $user->fullname(); ?></p><br>
                <p class="h5 lh140" >Has added <?php echo $lecture ?> Lecture for <?php echo $lecture->course->toLink() ?></p>
                <p class="h5 lh140" >It is scheduled on</p>
                <?php if($lecture->type == 'once') {?>
                <p class="h5 lh140 bold"><?php echo date('d M Y ', $lecture->start_date) . '';
                        echo date('h:i A ', $lecture->start_date) . ' to ' . date('h:i A ', $lecture->end_date);  ?></p>
                <?php } else {
                        $days = unserialize($lecture->when);
                    ?>
                    <table class="h5 lh140 fullwidth">
                        <tr>
                            <td class="bold" colspan = 2><?php echo date('d M Y ', $lecture->start_date) ?> to 
                            <?php echo date('d M Y ', $lecture->end_date) ?></td>
                        </tr>
                        <?php foreach($days as $day=>$time){ ?>
                        <?php $timing = explode(':',$time); ?>
                            <tr>
                                <td><?php echo $day ?></td>
                                <td><?php echo date('h:i A', strtotime(date('Y-m-d')) + ($timing[0] * 60)) .  ' to ' . date('h:i A', strtotime(date('Y-m-d')) + ($timing[1] * 60)) ?></td>
                            </tr>
                        <?php }?>
                    </table>
                    <?php }?><br>
                <p class = "h6 tlGray"><?php echo $span; ?></p>
            </td>
        </tr>
    </table>
