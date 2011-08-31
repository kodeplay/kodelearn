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
                <p class="h5 lh140" >Has added you to <?php echo $course->name; ?> course <?php if($count_user > 1){ echo "with <span class='bold'>".$count_user."</span> students"; } ?> 
                
                </p>
            </td>
        </tr>
    </table>
