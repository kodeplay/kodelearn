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
                <p class="h5 lh140" ><span class = "roleIcon <?php echo $user->role(); ?>">&nbsp;</span>Has added you to <?php echo $batch->name; ?> batch <?php if($count_user > 1){ echo "with <span class='bold'>".$count_user."</span> students"; } ?> 
                </p><br>
                <p class = "h6 tlGray"><?php echo $span; ?></p>
            </td>
        </tr>
    </table>
