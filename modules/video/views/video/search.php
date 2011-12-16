    <div class="r pagecontent">
        <div class="pageTop withBorder">
            <div class="pageTitle l w60">replace_here_page_title</div>
            <div class="pageDesc r">replace_here_page_description</div>
            <div class="clear"></div>
        </div><!-- pageTop -->
            <form name="search_form" id="search_form" method="POST" action="<?php echo $links_old['search'] ?>">
            <?php if (Acl::instance()->is_allowed('video_create')) { ?>
            <div class="pad5 hgtfix" style="border-top: 1px solid #4c3d34; border-bottom: 1px solid #4c3d34; vertical-align: middle; font-size: 12px;" >
                
                
                    <textarea name="search" id="search" class="l" style="height: 15px; width: 85%; resize: none;"><?php echo $search ? $search: '';?></textarea>
                    <a onclick="$('#search_form').submit();" class="button r">Search</a>
                
                <div class="clear"></div>
                
            </div><!-- topbar -->
            <?php } ?>
            </form>
            <form name="course" id="course" method="POST" class="selection-required" action="<?php echo $links_old['search'] ?>">
            <?php if($contents) { ?>
            <div class="pad5 hgtfix">
                <table style='width: 99%;'>
                        <tr>
                            <td colspan='3' style="padding-bottom: 5px;">
                                <a onclick="$('#course').submit();" class="button r">Save</a>
                            </td>
                        </tr>
                    <?php $i= 1; ?>
                    <?php foreach($contents as $content) { ?>
                        <tr>
                            <td style="padding-top: 10px; border-top: 1px solid #ccc;">
                                <input type="checkbox" class="selected" name="selected[]" value="<?php echo $i; ?>" />
                                <input type="hidden" name="videos[<?php echo $i; ?>][title]" value="<?php echo $content['title']; ?>"></input>
                                <input type="hidden" name="videos[<?php echo $i; ?>][description]" value="<?php echo $content['description']; ?>"></input>
                                <input type="hidden" name="videos[<?php echo $i; ?>][code]" value="<?php echo $content['code']; ?>"></input>
                            </td>
                            <td style='vertical-align: top; padding: 5px; border-top: 1px solid #ccc;'>
                                <img src='http://i1.ytimg.com/vi/<?php echo $content['code']; ?>/default.jpg' style='width: 120px;' />
                            </td>
                            <td style='vertical-align: top; padding: 5px; font-size: 12px; border-top: 1px solid #ccc;'>
                                <div id='title' style='color: #333; font-weight: bold;'><a href="http://youtu.be/<?php echo $content['code']; ?>" target="_blank"><?php echo $content['title']; ?></a></div>
                                <div id='text' style='padding-top: 10px; color: #777;'><?php echo htmlentities($content['description'], ENT_QUOTES, 'UTF-8'); ?></div>
                            </td>
                        </tr>
                        <?php $i++; ?>
                    <?php } ?>
                        <tr>
                            <td colspan='3' style="border-top: 1px solid #ccc; padding-top: 5px;">
                                <a onclick="$('#course').submit();" class="button r">Save</a>
                            </td>
                        </tr>
                </table>
            </div>
                
            <?php } ?>
            </form>       
    </div><!-- content -->
    
    <div class="clear"></div>

<script type="text/javascript">

    $(document).ready(function(){
        $("#search").watermark("Search");
    });

</script>