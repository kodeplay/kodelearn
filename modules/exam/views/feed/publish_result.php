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
                <p class="h5 lh140">Has published the results for exam group <a href=""><?php echo $percent['name']; ?></a><br>
               <?php if($percent['percent'] > $percent['passing_percent']){ ?>
                    You have <span class="tGreen">passed</span> with <span class="tGreen"><?php echo round($percent['percent'],2); ?> %</span>
                <?php } else {?>
                    You have <span class="tRed">failed</span> with <span class="tRed"><?php echo round($percent['percent'],2); ?> %</span>
                <?php } ?>
                </p>
            </td>
        </tr>
    </table>
 