<?php 
    $image = CacheImage::instance();
    $avatar = $image->resize($user->avatar, 75, 75);
?>

    
    <table class="fullwidth posts">
        <tr>
            <td class="w8">
                <img src = "<?php echo $avatar; ?>" class = "h70 "></img>
            </td>
            <td class="vatop hpad10">
                <p class="h3"><span class = "roleIcon <?php echo $user->role(); ?>">&nbsp;</span><?php echo $user->fullname(); ?></p><br>
                <p class="h5 lh140" ><?php echo Html::chars($post->message); ?></p><br/>
                <p class = "h6 tlGray"><?php echo $span; ?></p>
            </td>
            <td class="vatop w2">
                <?php if(Auth::instance()->get_user()->id == $user->id) { ?>
                    <a onclick="delete_post(this, <?php echo $post->id; ?>);" class="del-post" style="font-size: 13px; font-weight: bold; display: none; cursor: pointer;">X</a>
                <?php } else { ?>
                    &nbsp;
                <?php } ?>
            </td>
        </tr>
    </table>
<script type="text/javascript">

$(".posts").mouseenter(function () {
    $(this).find(".del-post").css('display','block');
});

$(".posts").mouseleave(function () {
	$(this).find(".del-post").css('display','none');
});

</script>