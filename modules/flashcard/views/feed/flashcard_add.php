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
                <p class="h5 lh140" >Has added a new set of flashcards <a href="<?php echo Url::site('flashcard/study/id/'.$flashcard->id); ?>"><?php echo $flashcard->title; ?></a><br>
                </p><br>
                <p class = "h6 tlGray"><?php echo $span; ?></p>
            </td>
        </tr>
    </table>
