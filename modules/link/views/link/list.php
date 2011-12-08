    <div class="r pagecontent">
        <div class="pageTop">
            <div class="pageTitle l">replace_here_page_title</div>
            <div class="pageDesc r">
                <?php if (Acl::instance()->is_allowed('link_delete')) { ?>
                    <a onclick="$('#course').submit();" class="pageAction r alert">Delete selected...</a>
                <?php } ?>  
            </div>
            <div class="clear"></div>
        </div><!-- pageTop -->        
        <?php if (Acl::instance()->is_allowed('link_create')) { ?>
            <div class="pad5 hgtfix" style="border-top: 1px solid #4c3d34; border-bottom: 1px solid #4c3d34; vertical-align: middle; font-size: 12px;" >
                
                
                    <textarea name="post" id="post" class="l" style="height: 15px; width: 89%; resize: none;"></textarea>
                    <a id="addLink" onclick="addLink();" class="button r">Add</a>
                
                <div class="clear"></div>
                <div id="loader" style="display: none; padding: 10px; width: 85%;"></div>
                <div id="link" style="border: 1px solid #ccc; display: none; padding: 10px; width: 85%;"></div>
                <input type="hidden" name="link_share" id="link_share" value="0" />
                <input type="hidden" name="video_share" id="video_share" value="0" />
            </div><!-- topbar -->
        <?php } ?>
        <?php if ($success) {  ?>
            <div class="formMessages w90">     
            <span class="fmIcon good"></span> <span class="fmText" ><?php echo $success ?></span>
            <span class="clear">&nbsp;</span>
            </div>
        <?php } ?>
        
        
        <form name="course" id="course" method="POST" class="selection-required" action="<?php echo $links_old['delete'] ?>">
        <div class="vm5" align="right">
            <select id="filter_select" name="filter_select" style="padding:2px; width:150px"> 
              <option value="filter_title">Title</option>
              <option value="filter_description">Description</option>
              
            </select>
            <input type="text" name="filter" id="filter" value="<?php echo $filter; ?>" style="padding:5px" />
            <a class="button" id="trigger_filter" href="#">Find</a>
            <input type="hidden" id="filter_url" value="<?php echo $filter_url ?>" />
            <input type="hidden" id="select_val" value="<?php echo $filter_select ?>" />
        </div>
        <table class="vm10 fullwidth">
           
            <?php foreach($table['data'] as $link){ ?>
            <tr style="border-top: 1px solid #aaa;">
                <td style='vertical-align: top; padding-top: 10px;'>
                    <input type="checkbox" class="selected" name="selected[]" value="<?php echo $link->id ?>" />
                </td>
                <td style="padding: 5px;">
                    <table style='width: 99%;'>
                        <tr>
                            <td style='vertical-align: top; padding: 5px;'>
                                <a href="<?php echo $link->url; ?>" target="_blank"><img src='<?php echo $link->image; ?>' style='width: 120px;' /></a>
                            </td>
                            <td style='vertical-align: top; padding: 5px; font-size: 13px;'>
                                <div id='title' style='font-weight: bold;'><a style="color: #666;" href="<?php echo $link->url; ?>" target="_blank"><?php echo $link->title; ?></a></div>
                                <div id='title' style='padding-top: 5px; font-size: 11px;;'><a href="<?php echo $link->url; ?>" target="_blank"><?php echo $link->url; ?></a></div>
                                <div id='text' style='padding-top: 10px; color: #777;'><?php echo htmlentities($link->description, ENT_QUOTES, 'UTF-8'); ?></div>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style='vertical-align: top; padding: 10px;'>
                    <?php if (Acl::instance()->is_allowed('link_edit')) { ?>
                        <a href="<?php echo $links_old['edit']."/id/".$link->id; ?>" style="font-size: 12px;">Edit</a>
                    <?php } ?>
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

    $(document).ready(function(){
        $("#post").watermark("Paste your link here to add");
    });
    
    $('#post').keyup(function() {
        var post = $("#post").val();
        var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
        var result = regexp.test(post);
        if(result == false) {
            $("#link_share").val('0');
            $("#video_share").val('0');
            $("#loader").html("");
            $("#link").html("");
            $("#loader").css('display', 'none');
            $("#link").css('display', 'none');
        }    
        if(result == true) {
            var loader = "<img src='"+ KODELEARN.config.base_url +"media/image/ajax-loader.gif' style='float: right;' />";
            $("#loader").html(loader);
            $("#loader").css('display', 'block');
            $("#link").html("");
            $("#link").css('display', 'none');
            $.ajax(
            {
                type: "POST",
                dataType:"json",
                url:     KODELEARN.config.base_url+"link/dataFromLink",
                data: "post=" + post,
                success: function(data)
                        {
                              if(data.link_share == '1') {
                                  $("#link_share").val('1');  
                                  var content = "<table style='width: 90%;'><tr>";
                                  content += "<td style='vertical-align: top; padding: 5px;'>";
                                  var j = 1;
                                  for(i=0; i<data.img.length; i++) {
                                      content += "<img id='logo_img_"+ j +"' src='"+ data.img[i] +"' style='width: 120px; display: none;' />";
                                      j++;
                                  }
                                  content += "</td>";
                                  content += "<td style='vertical-align: top; padding: 5px; font-size: 13px;'>";
                                  content += "<div id='title' style='color: #333; font-weight: bold;'>"+ data.title +"</div>";
                                  content += "<div id='text' style='padding-top: 10px; color: #777;'>"+ data.text +"</div>";
                                  content += "<div style='padding-top: 20px;'><a id='img_prev' class='button-arrow disabled' onclick='prev();'><</a> &nbsp; <a id='img_next' class='button-arrow' onclick='next();'>></a></div>";
                                  content += "<input type='hidden' id='post_img' name='post_img' value='"+ data.img[0] +"'>";
                                  content += "<input type='hidden' id='post_title' name='post_title' value='"+ data.title +"'>";
                                  content += "<input type='hidden' id='post_text' name='post_text' value='"+ data.text +"'>";
                                  content += "<input type='hidden' id='post_link' name='post_link' value='"+ data.link +"'>";
                                  content += "<input type='hidden' id='post_counter' value='1'>";
                                  content += "<input type='hidden' id='post_total_img' value='"+ data.img.length +"'>";
                                  content += "</td>";
                                  content += "</tr></table>";
                                  
                                  $("#link").html(content);
                                  $("#logo_img_1").css('display', 'block');
                                  $("#link").css('display', 'block');
                                  $("#loader").html("");
                                  $("#loader").css('display', 'none');
                                  if(data.img.length == 1){
                                      $("#img_next").addClass('disabled'); 
                                  }
                              } 
                              if(data.video_share == '1') {
                                  $("#video_share").val('1');
                                  var content = "<table style='width: 90%;'><tr>";
                                  content += "<td style='vertical-align: top; padding: 5px;'>";
                                  
                                  content += "<img src='"+ data.img +"' style='width: 120px;' />";
                                      
                                  content += "</td>";
                                  content += "<td style='vertical-align: top; padding: 5px; font-size: 13px;'>";
                                  content += "<div id='title' style='color: #333; font-weight: bold;'>"+ data.title +"</div>";
                                  content += "<div id='text' style='padding-top: 10px; color: #777;'>"+ data.text +"</div>";
                                  content += "<input type='hidden' id='post_img' name='post_img' value='"+ data.img +"'>";
                                  content += "<input type='hidden' id='post_title' name='post_title' value='"+ data.title +"'>";
                                  content += "<input type='hidden' id='post_text' name='post_text' value='"+ data.text +"'>";
                                  content += "<input type='hidden' id='post_link' name='post_link' value='"+ data.link +"'>";
                                  content += "<input type='hidden' id='post_counter' value='1'>";
                                  content += "</td>";
                                  content += "</tr></table>";
                                  
                                  $("#link").html(content);
                                  $("#link").css('display', 'block');
                                  $("#loader").html("");
                                  $("#loader").css('display', 'none');
                                  
                              } 
                            
                        },
                 error: function() {
                            $("#link_share").val('0');
                            $("#video_share").val('0');
                            $("#loader").html("");
                            $("#link").html("");
                            $("#loader").css('display', 'none');
                            $("#link").css('display', 'none'); 
                        } 
            });   
        }
        
    });

    function next() {
        var total = parseInt($('#post_total_img').val());
        var counter = parseInt($('#post_counter').val());
        var counter_plus_one = counter + 1;
        if(total < counter_plus_one) {
            $("#img_next").addClass('disabled');
            return false
        }
        $('#img_prev').removeClass('disabled')
        $('#post_counter').val(counter_plus_one);
        $("#logo_img_"+counter).css('display', 'none');
        $("#logo_img_"+counter_plus_one).css('display', 'block');
        $("#post_img").val($("#logo_img_"+counter_plus_one).attr('src'));
    }

    function prev() {
        var counter = parseInt($('#post_counter').val());
        var counter_minus_one = counter - 1;
        if(counter_minus_one < 1) {
            $("#img_prev").addClass('disabled');
            return false
        }
        $('#img_next').removeClass('disabled')
        $('#post_counter').val(counter_minus_one);
        $("#logo_img_"+counter).css('display', 'none');
        $("#logo_img_"+counter_minus_one).css('display', 'block');
        $("#post_img").val($("#logo_img_"+counter_minus_one).attr('src'));
    }

    function addLink() {
        $("#addLink").css('display', 'none');
        var post_img = $("#post_img").val();
        var post_title = $("#post_title").val();
        var post_text = $("#post_text").val();
        var post_link = $("#post_link").val();
        if(!post_link) {
        	$("#addLink").css('display', 'block');
            return false;
        }
        $.ajax(
            {
                type: "POST",
                dataType:"json",
                url:     KODELEARN.config.base_url+"link/add",
                data: "image=" + post_img +"&title=" + post_title + "&description=" + post_text + "&url=" + post_link,
                success: function(data)
                {
            	   window.location.href = KODELEARN.config.base_url+"link/index";
                } 
            });   
    }
    
    </script>
 
