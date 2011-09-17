<?php 
    $image = CacheImage::instance();
    $avatar = $image->resize($user->avatar, 75, 75);
?>

    
    <table class="fullwidth">
        <tr>
            <td class="w8">
                <img src = "<?php echo $avatar; ?>" class = "h70 "></img>
            </td>
            <td class="vatop hpad10">
                <p class="h3"><span class = "roleIcon <?php echo $user->role(); ?>">&nbsp;</span><?php echo $user->fullname(); ?></p><br>
                <p class="h5 lh140" >Has added a new exam <a href="<?php echo Url::site('exam'); ?>"><?php echo $exam; ?></a><br>
                This is a <?php echo $exam->total_marks; ?> marks exam and passing is <?php echo $exam->passing_marks; ?> marks<br>
                It will be held on <a class="crsrPoint" onclick="Feeds.show('<?php echo date("d", $event->eventstart); ?>','<?php echo date("m", $event->eventstart); ?>','<?php echo date("Y", $event->eventstart); ?>')"><?php echo date("d M Y", $event->eventstart); ?></a> from <a href="#"><?php echo date("g:i a", $event->eventstart); ?></a> to <a href="#"><?php echo date("g:i a", $event->eventend); ?></a>
                </p><br>
                <p class = "h6 tlGray"><?php echo $span; ?></p>
            </td>
        </tr>
    </table>
