    <div class="r pagecontent">
        <div class="pageTop">
            <div class="pageTitle l">replace_here_page_title</div>
            <div class="pageDesc r">
                <?php if (Acl::instance()->is_allowed('video_delete')) { ?>
                    <a onclick="$('#course').submit();" class="pageAction r alert">Delete selected...</a>
                <?php } ?>  
            </div>
            <div class="clear"></div>
        </div><!-- pageTop -->        
        
        <?php if ($success) {  ?>
            <div class="formMessages w90">     
            <span class="fmIcon good"></span> <span class="fmText" ><?php echo $success ?></span>
            <span class="clear">&nbsp;</span>
            </div>
        <?php } ?>
        
        
        <form name="course" id="course" method="POST" class="selection-required" action="<?php echo $links_old['delete'] ?>">
        
        <div class="vm5">
            <div style="float: left; padding: 10px;">
                <a href="<?php echo $links_old['add'] ?>" class="button">Add</a> or <a href="<?php echo $links_old['search'] ?>">Search from YouTube</a>
                
            </div>
            <div style="float: right;">
                <select id="filter_select" name="filter_select" style="padding:2px; width:150px"> 
                  <option value="filter_title">Title</option>
                  <option value="filter_description">Description</option>
                  
                </select>
                <input type="text" name="filter" id="filter" value="<?php echo $filter; ?>" style="padding:5px" />
                <a class="button" id="trigger_filter" href="#">Find</a>
                <input type="hidden" id="filter_url" value="<?php echo $filter_url ?>" />
                <input type="hidden" id="select_val" value="<?php echo $filter_select ?>" />
            </div>
            <div class="clear"></div>
        </div>
        <table class="vm10 fullwidth">
           
            <?php foreach($table['data'] as $video){ ?>
            <tr style="border-top: 1px solid #aaa;">
                <td style='vertical-align: top; padding-top: 10px;'>
                    <input type="checkbox" class="selected" name="selected[]" value="<?php echo $video->id ?>" />
                </td>
                <td style="padding: 5px;">
                    <table style='width: 99%;'>
                        <tr>
                            <td style='vertical-align: top; padding: 5px; width: 135px;'>
                                <a class="img" href="http://youtu.be/<?php echo $video->code; ?>" target="_blank" style="cursor: pointer;"><img src='http://i1.ytimg.com/vi/<?php echo $video->code; ?>/default.jpg' style='width: 120px;' /></a>
                                <div class="vid" style="display: none;">
                                    
                                </div>
                                
                            </td>
                            <td class="desc" style='vertical-align: top; padding: 5px; font-size: 12px;'>
                                <div id='title' style='color: #333; font-weight: bold;'><a href="http://youtu.be/<?php echo $video->code; ?>" target="_blank"><?php echo $video->title; ?></a></div>
                                <div id='text' style='padding-top: 10px; color: #777;'><?php echo htmlentities($video->description, ENT_QUOTES, 'UTF-8'); ?></div>
                            </td>
                        </tr>
                    </table> 
                </td>
                <td style='vertical-align: top; padding: 10px;'>
                    <a class="view" onclick="showVid(this,'<?php echo $video->code; ?>');" style="font-size: 12px; cursor: pointer;">View</a>
                    <a class="minimize" onclick="hideVid(this);" style="font-size: 12px; font-weight: bold; display: none; cursor: pointer;">X</a>
                </td>
            </tr>
            <?php }?>
            <?php if($count == 0){ ?>
                <tr>
                    <td colspan="6" align="center">
                        No Records Found
                    </td>
                </tr>
                <?php } ?>
                <tr class="pagination">
                    <td class="tar pagination" colspan="6">
                        <?php echo $pagination ?>
                    </td>
                </tr>
        </table>
        </form>
    </div><!-- content -->
    
    <div class="clear"></div>
    
    <script type="text/javascript">

    

    function showVid(self,code) {
        $(self).parent().siblings().find('.img').toggle('slow');
        $(self).parent().siblings().find('.desc').toggle('slow');
    	var content = "<iframe width='450' height='240' src='http://www.youtube.com/embed/"+ code +"?version=3&autohide=1&autoplay=1' frameborder='0' allowfullscreen></iframe>";
    	$(self).parent().siblings().find('.vid').html(content);
    	$(self).parent().siblings().find('.vid').toggle('slow');
        $(self).toggle('slow');
        $(self).siblings().toggle('slow');
        
    }

    function hideVid(self) {
    	$(self).parent().siblings().find('.vid').toggle('slow');
    	$(self).toggle('slow');
    	$(self).siblings().toggle('slow');
    	$(self).parent().siblings().find('.img').toggle('slow');
        $(self).parent().siblings().find('.desc').toggle('slow');
    }
    
    </script>
 
