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
                <p class="h5 lh140" >Has marked you <?php if($attendance->present == "1") { ?><span class='tGreen'>present</span><?php } else { ?><span class='tRed'>absent</span><?php }?> for <?php echo $event->eventtype." ".$event_details->name; ?> <br>
                Held on <?php echo date('d M Y',$event->eventstart); ?>
                </p>
            </td>
        </tr>
    </table>
