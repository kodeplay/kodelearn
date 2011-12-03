<?php 
    $image = CacheImage::instance();
    $avatar = $image->resize($user->avatar, 75, 75);
    
    $curr_user = Auth::instance()->get_user();
    $curr_avatar = $image->resize($curr_user->avatar, 40, 40);
?>

    
    <table class="fullwidth">
        <tr>
            <td class="w8">
                <a href="<?php echo $url."/".$user->id; ?>"><img src = "<?php echo $avatar; ?>" class = "h70 "></img></a>
            </td>
            <td class="vatop hpad10">
                <p class="h3"><span class = "roleIcon <?php echo $user->role(); ?>">&nbsp;</span><a href="<?php echo $url."/".$user->id; ?>"><?php echo $user->fullname(); ?></a></p><br>
                <p class="h5 lh140" >Has added a new document <?php echo $document->toLink() ?><br>
                </p>
                <span class="h6 tlGray"><?php echo $span; ?></span>
                
                <a class="h6" style="cursor: pointer;" onclick="show_comment_entry_box(this, '<?php echo $curr_avatar; ?>', '<?php echo $feed_id; ?>')"><span class="h6 tlGray">-</span> Comment</a>
                
                <?php if(count($comments) > 4) { ?>
                    
                    <a class="h6" style="cursor: pointer;" onclick="showViewLimit(this)"><span class="h6 tlGray">-</span> View All (<?php echo count($comments); ?>)</a>
                <?php } ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td colspan="2" class="comments vatop pad10">
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
                            <tr class="view-limit del-comm" style='border-top: 1px solid #fff; display: none'>
                                <td class='pad5' style='width: 40px;'>
                                    <a href="<?php echo $url."/".$comment->user_id; ?>"><img src='<?php echo $comment_img; ?>' style='width: 40px; height: 40px;' /></a>
                                </td>
                                <td class='vatop pad5' style='width: 350px;'>
                                    <a href="<?php echo $url."/".$comment->user_id; ?>" style='font-size: 14px; font-weight: bold;'><?php echo $comment_user->firstname." ".$comment_user->lastname ?></a>
                                    <span class='hpad10' style='font-size: 12px;'><?php echo Html::chars($comment->comment); ?></span>
                                    <p class='vpad10' style='font-size: 11px; color: #777;'><?php echo Date::fuzzy_span($comment->date); ?></p>
                                </td>
                                <td class="vatop w2 pad5">
                                    <?php if(Acl::instance()->is_allowed('post_delete') && $role == 'Admin') { ?>
                                        <a onclick="delete_comment(this, <?php echo $comment->id; ?>);" class="del-comment" style="font-size: 11px; font-weight: bold; display: none; cursor: pointer;">X</a>
                                    <?php } else if(Acl::instance()->is_allowed('post_delete') && $role == 'studentmoderator' && $user->role()->name == 'Student') { ?>
                                        <a onclick="delete_comment(this, <?php echo $comment->id; ?>);" class="del-comment" style="font-size: 11px; font-weight: bold; display: none; cursor: pointer;">X</a>
                                    <?php } else if(Acl::instance()->is_allowed('post_delete') && $role == 'Teacher' && $user->role()->name == 'Student') { ?>
                                        <a onclick="delete_comment(this, <?php echo $comment->id; ?>);" class="del-comment" style="font-size: 11px; font-weight: bold; display: none; cursor: pointer;">X</a>
                                    <?php } else { ?>
                                            <?php if(Auth::instance()->get_user()->id == $comment->user_id) { ?>
                                                <a onclick="delete_selfcomment(this, <?php echo $comment->id; ?>);" class="del-comment" style="font-size: 11px; font-weight: bold; display: none; cursor: pointer;">X</a>
                                            <?php } else { ?>
                                                &nbsp;
                                            <?php } ?>
                                    <?php } ?>
                                </td>
                            </tr>
                        <?php } else {?>
                            <tr class="del-comm" style='border-top: 1px solid #fff; display: block'>
                                <td class='pad5' style='width: 40px;'>
                                    <a href="<?php echo $url."/".$comment->user_id; ?>"><img src='<?php echo $comment_img; ?>' style='width: 40px; height: 40px;' /></a>
                                </td>
                                <td class='vatop pad5' style='width: 350px;'>
                                    <a href="<?php echo $url."/".$comment->user_id; ?>" style='font-size: 14px; font-weight: bold;'><?php echo $comment_user->firstname." ".$comment_user->lastname ?></a>
                                    <span class='hpad10' style='font-size: 12px;'><?php echo Html::chars($comment->comment); ?></span>
                                    <p class='vpad10' style='font-size: 11px; color: #777;'><?php echo Date::fuzzy_span($comment->date); ?></p>
                                </td>
                                <td class="vatop w2 pad5">
                                    <?php if(Acl::instance()->is_allowed('post_delete') && $role == 'Admin') { ?>
                                        <a onclick="delete_comment(this, <?php echo $comment->id; ?>);" class="del-comment" style="font-size: 11px; font-weight: bold; display: none; cursor: pointer;">X</a>
                                    <?php } else if(Acl::instance()->is_allowed('post_delete') && $role == 'studentmoderator' && $user->role()->name == 'Student') { ?>
                                        <a onclick="delete_comment(this, <?php echo $comment->id; ?>);" class="del-comment" style="font-size: 11px; font-weight: bold; display: none; cursor: pointer;">X</a>
                                    <?php } else if(Acl::instance()->is_allowed('post_delete') && $role == 'Teacher' && $user->role()->name == 'Student') { ?>
                                        <a onclick="delete_comment(this, <?php echo $comment->id; ?>);" class="del-comment" style="font-size: 11px; font-weight: bold; display: none; cursor: pointer;">X</a>
                                    <?php } else { ?>
                                        <?php if(Auth::instance()->get_user()->id == $comment->user_id) { ?>
                                            <a onclick="delete_selfcomment(this, <?php echo $comment->id; ?>);" class="del-comment" style="font-size: 11px; font-weight: bold; display: none; cursor: pointer;">X</a>
                                        <?php } else { ?>
                                            &nbsp;
                                        <?php } ?>
                                    <?php } ?>
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

<script type="text/javascript">

$(".del-comm").live('mouseenter', function () {
    $(this).find(".del-comment").css('display','block');
});

$(".del-comm").live('mouseleave', function () {
    $(this).find(".del-comment").css('display','none');
});

</script>
