<?php 
    $image = CacheImage::instance();
    $avatar = $image->resize('', 75, 75);
?>
<table class="fullwidth">
        <tbody><tr>
            <td class="w8">
                <img src="<?php echo $avatar ?>" />
            </td>
            <td class="vatop hpad10">
                <p class="h3">The Content is currently unavaliable.</p>
            </td>
        </tr>
    </tbody></table>