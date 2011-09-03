<?php 
    $image = CacheImage::instance();
    $avatar = $image->resize('', 50, 50);
?>
<table class="fullwidth">
        <tbody><tr>
            <td class="w8">
                <img src="<?php echo $avatar ?>" />
            </td>
            <td class="vatop">
                <p class="h3">The Content is currently unavaliable.</p>
            </td>
        </tr>
    </tbody></table>