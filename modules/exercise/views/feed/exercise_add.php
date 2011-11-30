<?php 
    $image = CacheImage::instance();
    $avatar = $image->resize($user->avatar, 75, 75);
    
    $curr_user = Auth::instance()->get_user();
    $curr_avatar = $image->resize($curr_user->avatar, 40, 40);
?>

    
    <table class="fullwidth">
        <tr>
            <td class="w8">
                <img src = "<?php echo $avatar; ?>" class = "h70 "></img>
            </td>
            <td class="vatop hpad10">
                <p class="h3"><span class = "roleIcon <?php echo $user->role(); ?>">&nbsp;</span><?php echo $user->fullname(); ?></p><br>
                <p class="h5 lh140" >Has added an exercise <a href="<?php echo Url::site('exercise/start/id/'.$exercise->id); ?>"><?php echo $exercise->title; ?></a><br>
                </p><br>
                <span class="h6 tlGray"><?php echo $span; ?></span>
                
                <a class="h6" style="cursor: pointer;" onclick="show_comment_entry_box(this, '<?php echo $curr_avatar; ?>', '<?php echo $feed_id; ?>')"><span class="h6 tlGray">-</span> Comment</a>
                
                <?php if(count($comments) > 4) { ?>
                    
                    <a class="h6" style="cursor: pointer;" onclick="showViewLimit(this)"><span class="h6 tlGray">-</span> View All (<?php echo count($comments); ?>)</a>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td class="comments vatop pad10">
               <table class="existing-comments" style='width: 60%; background: #eee;'>
               <?php if($comments) { ?>
                    <?php $i = 0; ?>
                    <?php foreach($comments as $comment) { ?>
                        <?php 
                            $i++;
                            $comment->user_id;
                            $comment_user = ORM::factory('user',$comment->user_id);
                            $comment_img = $image->resize($comment_user->avatar, 40, 40); 
                        ?>
                        <?php if($i > 4) { ?>
                            <tr class="view-limit" style='border-top: 1px solid #fff; display: none'>
                                <td class='pad5' style='width: 40px;'>
                                    <img src='<?php echo $comment_img; ?>' style='width: 40px; height: 40px;' />
                                </td>
                                <td class='vatop pad5'>
                                    <a style='font-size: 14px; font-weight: bold;'><?php echo $comment_user->firstname." ".$comment_user->lastname ?></a>
                                    <span class='hpad10' style='font-size: 12px;'><?php echo Html::chars($comment->comment); ?></span>
                                    <p class='vpad10' style='font-size: 11px; color: #777;'><?php echo Date::fuzzy_span($comment->date); ?></p>
                                </td>
                            </tr>
                        <?php } else {?>
                            <tr style='border-top: 1px solid #fff; display: block'>
                                <td class='pad5' style='width: 40px;'>
                                    <img src='<?php echo $comment_img; ?>' style='width: 40px; height: 40px;' />
                                </td>
                                <td class='vatop pad5'>
                                    <a style='font-size: 14px; font-weight: bold;'><?php echo $comment_user->firstname." ".$comment_user->lastname ?></a>
                                    <span class='hpad10' style='font-size: 12px;'><?php echo Html::chars($comment->comment); ?></span>
                                    <p class='vpad10' style='font-size: 11px; color: #777;'><?php echo Date::fuzzy_span($comment->date); ?></p>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
               <?php } ?>
               </table>
               <table class="new-comments" style='width: 60%; background: #eee;'>
               </table>
            </td>
        </tr>
    </table>
