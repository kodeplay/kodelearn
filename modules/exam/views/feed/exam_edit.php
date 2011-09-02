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
                <p class="h5 lh140">Has updated the exam <a href="<?php echo Url::site('exam'); ?>"><?php echo $exam; ?></a><br>
                It is now <?php echo $exam->total_marks; ?> marks exam and passing is <?php echo $exam->passing_marks; ?> marks<br>
                It will be held on <a href="#"><?php echo date("d M Y", $event->eventstart); ?></a> from <a href="#"><?php echo date("g:i a", $event->eventstart); ?></a> to <a href="#"><?php echo date("g:i a", $event->eventend); ?></a>
                </p><br>
                <p class = "h6 tlGray"><?php echo $span; ?></p>
            </td>
        </tr>
    </table>
  