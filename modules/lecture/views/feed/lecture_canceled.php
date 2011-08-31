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
                <p class="h5 lh140 tRed" >The <?php echo $lecture ?> Lecture On <?php echo date('d-m-Y h:i A',$event->eventstart) ?> has been cancelled.</p>
            </td>
        </tr>
    </table>
