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
                <p class="h5 lh140 tRed" ><span class = "roleIcon <?php echo $user->role(); ?>">&nbsp;</span>The <?php echo $lecture ?> Lecture On <?php echo date('d F Y h:i A',$event->eventstart) ?> has been cancelled.</p>
                <br>
                <p class = "h6 tlGray"><?php echo $span; ?></p>
            </td>
        </tr>
    </table>
