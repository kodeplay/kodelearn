    <div class="r pagecontent">
        <div class="pageTop withBorder">
            <div class="pageTitle l w60">replace_here_page_title</div>
            <div class="pageDesc r">replace_here_page_description</div>
            <div class="clear"></div>
        </div><!-- pageTop -->
        
            <?php if (Acl::instance()->is_allowed('video_create')) { ?>
            <div class="pad5 hgtfix" style="border-top: 1px solid #4c3d34; border-bottom: 1px solid #4c3d34; vertical-align: middle; font-size: 12px;" >
                
                
                    <textarea name="post" id="post" class="l" style="height: 15px; width: 89%; resize: none;"></textarea>
                    <a id="addLink" onclick="addLink();" class="button r">Save</a>
                
                <div class="clear"></div>
               
                <input type="hidden" name="link_share" id="link_share" value="0" />
                <input type="hidden" name="video_share" id="video_share" value="0" />
            </div><!-- topbar -->
            <?php } ?>
            <div style="padding-top: 10px;">
                 <div id="loader" style="display: none; padding: 10px; width: 85%;"></div>
                 <div id="link" style="border: 1px solid #ccc; display: none; padding: 10px; width: 97%;"></div>
            </div>
        
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
                url:     KODELEARN.config.base_url+"video/dataFromLink",
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
                                  var content = "<table style='width: 99%;'><tr>";
                                  content += "<td style='padding: 10px;'>Image</td>"
                                  content += "<td style='vertical-align: top; padding: 10px;'>";
                                  content += "<img src='"+ data.img +"' style='width: 120px;' />";
                                  content += "</td></tr>";
                                  content += "<tr><td style='vertical-align: top; padding: 10px;'>";
                                  content += "Title</td>";
                                  content += "<td style='padding: 10px;'>";
                                  content += "<textarea name='post_title' id='post_title' class='link_text_area'>"+ data.title +"</textarea>";
                                  content += "</td></tr>";
                                  content += "<tr><td style='vertical-align: top; padding: 10px;'>";
                                  content += "Description</td>";
                                  content += "<td style='padding: 10px;'>";
                                  content += "<textarea name='post_text' id='post_text' class='link_text_area'>"+ data.text +"</textarea>";
                                  content += "</td></tr>";
                                  content += "</table>";
                                  content += "<input type='hidden' id='post_img' name='post_img' value='"+ data.img +"'>";
                                  content += "<input type='hidden' id='post_link' name='post_link' value='"+ data.link +"'>";
                                  content += "<input type='hidden' id='post_code' name='post_code' value='"+ data.code +"'>";
                                  content += "<input type='hidden' id='post_counter' value='1'>";
                                  
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
        var post_code = $("#post_code").val();
        var post_title = $("#post_title").val();
        var post_text = $("#post_text").val();
        if(!post_code) {
            $("#addLink").css('display', 'block');
            return false;
        }
        $.ajax(
            {
                type: "POST",
                dataType:"json",
                url:     KODELEARN.config.base_url+"video/add",
                data: "code=" + post_code +"&title=" + post_title + "&description=" + post_text,
                success: function(data)
                {
                   window.location.href = KODELEARN.config.base_url+"video/index";
                } 
            });   
    }

</script>