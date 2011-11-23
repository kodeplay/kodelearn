    <div class="r pagecontent">
        <div class="pageTop withBorder">
            <div class="pageTitle l w50"><?php echo $current_card; ?></div>
            <div id="other_links" class="pageDesc r dib" style="border: 0px solid black; height: 40px; width: 350px;">| 
                <?php if($cards) { ?>
                    <?php foreach($cards as $card) { ?>
                        <?php echo Html::anchor('/flashcard/study/id/'.$card->id, $card->title) ?> |
                    <?php } ?>
                <?php } ?>
            </div>
            <div class="clear"></div>
        </div><!-- pageTop -->
        <div id="main" style="margin-top: 20px;">
            <a id="previous" class="" onclick="getPrevious();" style="float: left; cursor: pointer; font-weight: bold; margin-right: 10px; margin-top: 130px;"> << Prev</a>
            <div id="main_container" style="width: 640px; border: 1px solid #ccc; float: left; -webkit-box-shadow: 0 0 5px #333; -moz-box-shadow: 0 0 5px #333; box-shadow: 0 0 5px #333; border-radius: 8px;">
                <div style="float:left; padding: 10px; font-size: 13px; color: #444;">
                    <a id="max" class="max-screen dib" onclick="maximize();" style="cursor: pointer;"></a>
                    <a id="min" class="min-screen dib" onclick="min();" style="display: none; cursor: pointer;"></a>
                </div>
                <div style="float:right; padding: 5px; font-size: 13px; color: #444;">
                    <input type="checkbox" checked="checked" id="both_sides" onclick="check_event()" />Both Sides
                </div>
                <div class="clear"></div>
                <div class="flipbox" id="flipbox_question" style="display: table-cell; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc;"></div>
                <div id="flip_div" style="float:right; padding: 8px; font-size: 14px; font-style: italic;">
                    <a onclick="flipAnswer()" style="cursor: pointer;">Click to flip</a>
                </div>
                <div class="clear"></div>
            </div>
            <a id="next" class="" onclick="getNext();" style="float: left; cursor: pointer; font-weight: bold; margin-left: 10px; margin-top: 130px;">Next >></a>
            <div class="clear"></div>
            <?php if($questions) { ?>
                <?php $i= "1"; ?>
                <?php foreach($questions as $question) { ?>
                    <div id="question_<?php echo $i; ?>" style="display: none;" class="sec-container">
                        <div id="f_question" style="font-size: 22px; font-weight: bold; padding-top: 10px;"><?php echo $question->question; ?></div>
                        
                    </div>
                    <div id="answer_<?php echo $i; ?>" style="display: none;">
                        <div id="f_answer" style="font-size: 18px; padding-top: 20px;"><?php echo $question->attribute_value; ?></div>
                        <div id="f_explanation" style="font-size: 16px; padding-top: 10px;"><?php echo $question->explanation; ?></div>
                    </div>
                    <?php $i++; ?>
                <?php } ?>
            <?php } ?>
        </div>
        <div style="margin-top: 10px;">
            
            <div class="clear"></div>
            <input id="hidden_counter" type="hidden" value="1"></input>
            <input id="question_answer" type="hidden" value="1"></input>
            <input id="toggle_min_max" type="hidden" value="0"></input>
        </div>
        
        
    </div><!-- content -->
    
    <div class="clear"></div>
<script type="text/javascript">
$(document).ready(function() {
    var hidden_counter = 1;
    var count = "<?php echo count($questions); ?>";
    if(count == "1") {
    	$("#next").css('color','#ccc');
    	
    }
    $("#previous").css('color','#ccc'); 
	var question_content = $("#question_"+hidden_counter).html();
	var answer_content = $("#answer_"+hidden_counter).html();
	$("#question_answer").val('1');
    var status = $("#both_sides").attr('checked');
    if($('#toggle_min_max').val() == '1') {
        $('#f_question').css('font-size', '32px');
        $('#f_answer').css('font-size', '28px');
        $('#f_explanation').css('font-size', '26px');
    } 
    if(status == "checked") {
    	$("#flipbox_question").html(question_content + answer_content);
        $( "#flip_div" ).css('display','none');
    } else {
    	$("#flipbox_question").html(question_content);
        $( "#flip_div" ).css('display','block');
    }
    return false;
});

function check_event() {
	var hidden_counter = parseInt($("#hidden_counter").val());
    var question_content = $("#question_"+hidden_counter).html();
    var answer_content = $("#answer_"+hidden_counter).html();
    $("#question_answer").val('1');
    var status = $("#both_sides").attr('checked');
    
    if(status == "checked") {
        $("#flipbox_question").html(question_content + answer_content);
        $( "#flip_div" ).css('display','none');
    } else {
        $("#flipbox_question").html(question_content);
        $( "#flip_div" ).css('display','block');
    }
    if($('#toggle_min_max').val() == '1') {
        $('#f_question').css('font-size', '32px');
        $('#f_answer').css('font-size', '28px');
        $('#f_explanation').css('font-size', '26px');
    } 
    return false;
}

function getNext() {
	var count = "<?php echo count($questions); ?>";
	var hidden_counter = parseInt($("#hidden_counter").val());
	$("#question_answer").val('1');
	if(count != "1") {
		   $("#previous").css('color','');
	}
	
    if(hidden_counter < count) {
    	if((hidden_counter + 1) == count) {
            $("#next").css('color','#ccc');
        }
        var hidden_counter_plus_one = hidden_counter + 1;
        $("#hidden_counter").val(hidden_counter_plus_one);
    	var question_content = $("#question_"+hidden_counter_plus_one).html();
    	var answer_content = $("#answer_"+hidden_counter_plus_one).html();
    	var status = $("#both_sides").attr('checked');
    	if(status == "checked") {
            $("#flipbox_question").html(question_content + answer_content);
        } else {
            $("#flipbox_question").html(question_content);
        }
    	if($('#toggle_min_max').val() == '1') {
            $('#f_question').css('font-size', '32px');
            $('#f_answer').css('font-size', '28px');
            $('#f_explanation').css('font-size', '26px');
        }  
        return false;
    } else {
    	return false;
    }
}

function getPrevious() {
	var count = "1";
    var hidden_counter = parseInt($("#hidden_counter").val());
    $("#question_answer").val('1');
    if("<?php echo count($questions); ?>" != "1") {
        $("#next").css('color','');
    }
    
    if(hidden_counter > count) {
    	if((hidden_counter - 1) == 1) {
            $("#previous").css('color','#ccc');
        } 
        var hidden_counter_plus_one = hidden_counter - 1;
        $("#hidden_counter").val(hidden_counter_plus_one);
        var question_content = $("#question_"+hidden_counter_plus_one).html();
        var answer_content = $("#answer_"+hidden_counter_plus_one).html();
        $("#flipbox_question").html(question_content + answer_content);
        var status = $("#both_sides").attr('checked');
        if(status == "checked") {
            $("#flipbox_question").html(question_content + answer_content);
        } else {
            $("#flipbox_question").html(question_content);
        }
        if($('#toggle_min_max').val() == '1') {
            $('#f_question').css('font-size', '32px');
            $('#f_answer').css('font-size', '28px');
            $('#f_explanation').css('font-size', '26px');
        } 
        
        return false;
    } else {
        return false;
    }
}

function flipAnswer() {
	var status = $("#both_sides").attr('checked');
	if(status == "checked") {
	    return false;
	}
	
    var question_answer = $("#question_answer").val();
    var hidden_counter = parseInt($("#hidden_counter").val());

    if(question_answer == '1') {
        $("#question_answer").val('0');
        var answer_content = $("#answer_"+hidden_counter).html();
        $("#flipbox_question").flip({
            color: '#fafafa',
            direction: 'lr',
            content: answer_content,//(new Date()).getTime(),
            onBefore: function(){
                     $("#main_container").css('-webkit-box-shadow', '');
                     $("#main_container").css('-moz-box-shadow', '');
                     $("#main_container").css('box-shadow', '');
                 },
            onEnd: function(){
                     $("#main_container").css('-webkit-box-shadow', '0 0 5px #333');
                     $("#main_container").css('-moz-box-shadow', '0 0 5px #333');
                     $("#main_container").css('box-shadow', '0 0 5px #333');
                     if($('#toggle_min_max').val() == '1') {
                         $('#f_question').css('font-size', '32px');
                         $('#f_answer').css('font-size', '28px');
                         $('#f_explanation').css('font-size', '26px');
                     }
                 }
        })
    } else {
        $("#question_answer").val('1');
        var question_content = $("#question_"+hidden_counter).html();
        $("#flipbox_question").flip({
            color: '#fafafa',
            direction: 'rl',
            content: question_content,//(new Date()).getTime(),
            onBefore: function(){
                $("#main_container").css('-webkit-box-shadow', '');
                $("#main_container").css('-moz-box-shadow', '');
                $("#main_container").css('box-shadow', '');
                },
            onEnd: function(){
                $("#main_container").css('-webkit-box-shadow', '0 0 5px #333');
                $("#main_container").css('-moz-box-shadow', '0 0 5px #333');
                $("#main_container").css('box-shadow', '0 0 5px #333');
                if($('#toggle_min_max').val() == '1') {
                    $('#f_question').css('font-size', '32px');
                    $('#f_answer').css('font-size', '28px');
                    $('#f_explanation').css('font-size', '26px');
                }
                }
        })
    } 
        
    return false;
    
}

function maximize() {
	$('.sidebar').toggle('slow');
	$('.pageTop').toggle('slow');
	$('.branding').toggle('slow');
	$('#breadcrumbs').toggle('slow');
	$('#main_container').css('width', '830px');
	$('.flipbox').css('width', '810px');
	$('.flipbox').css('height', '500px');
	$('.pagecontent').css('float', 'left');
	$('.pagecontent').css('width', '960px');
	$('#min').css('display', 'block');
	$('#max').css('display', 'none');
	$('#previous').css('margin-top', '250px');
	$('#next').css('margin-top', '250px');
	$('#f_question').css('font-size', '32px');
	$('#f_answer').css('font-size', '28px');
	$('#f_explanation').css('font-size', '26px');
	$('#toggle_min_max').val('1');
}

function min() {
    $('.sidebar').toggle('slow');
    $('.pageTop').toggle('slow');
    $('.branding').toggle('slow');
    $('#breadcrumbs').toggle('slow');
    $('#main_container').css('width', '640px');
    $('.flipbox').css('width', '620px');
    $('.flipbox').css('height', '300px');
    $('.pagecontent').css('float', '');
    $('.pagecontent').css('width', '');
    $('#min').css('display', 'none');
    $('#max').css('display', 'block');
    $('#previous').css('margin-top', '130px');
    $('#next').css('margin-top', '130px');
    $('#f_question').css('font-size', '22px');
    $('#f_answer').css('font-size', '18px');
    $('#f_explanation').css('font-size', '16px');
    $('#toggle_min_max').val('0');
}

$('#flipbox_question').click(function(){
	flipAnswer();
})
</script> 