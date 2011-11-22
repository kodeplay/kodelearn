    <div class="r pagecontent">
        <div class="pageTop withBorder">
            <div class="pageTitle l w60">replace_here_page_title</div>
            <div class="pageDesc r">replace_here_page_description</div>
            <div class="clear"></div>
        </div><!-- pageTop -->
        <div style="margin-top: 10px;">
            <a id="previous" class="" onclick="getPrevious();" style="float: left; cursor: pointer; font-weight: bold; margin-right: 10px; margin-top: 130px;"> << Prev</a>
            <div style="width: 640px; border: 1px solid #ccc; float: left; -webkit-box-shadow: 0 0 5px #333; -moz-box-shadow: 0 0 5px #333; box-shadow: 0 0 5px #333; border-radius: 8px;">
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
            <a id="next" class="" onclick="getNext();" style="float: right; cursor: pointer; font-weight: bold; margin-right: 10px; margin-top: 130px;">Next >></a>
            <div class="clear"></div>
            <?php if($questions) { ?>
                <?php $i= "1"; ?>
                <?php foreach($questions as $question) { ?>
                    <div id="question_<?php echo $i; ?>" style="display: none;" class="sec-container">
                        <div style="font-size: 20px; font-weight: bold; padding-top: 10px;"><?php echo $question->question; ?></div>
                        
                    </div>
                    <div id="answer_<?php echo $i; ?>" style="display: none;">
                        <div style="font-size: 18px; padding-top: 10px;"><?php echo $question->attribute_value; ?></div>
                        <div style="font-size: 16px; padding-top: 10px;"><?php echo $question->explanation; ?></div>
                    </div>
                    <?php $i++; ?>
                <?php } ?>
            <?php } ?>
        </div>
        <div style="margin-top: 10px;">
            
            <div class="clear"></div>
            <input id="hidden_counter" type="hidden" value="1"></input>
            <input id="question_answer" type="hidden" value="1"></input>
        </div>
        
        
    </div><!-- content -->
    
    <div class="clear"></div>
<script type="text/javascript">
$(document).ready(function() {
    var hidden_counter = 1;
	var question_content = $("#question_"+hidden_counter).html();
	var answer_content = $("#answer_"+hidden_counter).html();
	$("#question_answer").val('1');
    var status = $("#both_sides").attr('checked');
    if(status == "checked") {
    	$("#flipbox_question").html(question_content + answer_content);
        $( "#flipbox_question" ).effect('slide');
        $( "#flip_div" ).css('display','none');
    } else {
    	$("#flipbox_question").html(question_content);
        $( "#flipbox_question" ).effect('slide');
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
        $( "#flipbox_question" ).effect('slide');
        $( "#flip_div" ).css('display','none');
    } else {
        $("#flipbox_question").html(question_content);
        $( "#flipbox_question" ).effect('slide');
        $( "#flip_div" ).css('display','block');
    }
    return false;
}

function getNext() {
	var count = "<?php echo count($questions); ?>";
	var hidden_counter = parseInt($("#hidden_counter").val());
	$("#question_answer").val('1');
    if(hidden_counter < count) {
        var hidden_counter_plus_one = hidden_counter + 1;
        $("#hidden_counter").val(hidden_counter_plus_one);
    	var question_content = $("#question_"+hidden_counter_plus_one).html();
    	var answer_content = $("#answer_"+hidden_counter_plus_one).html();
    	var status = $("#both_sides").attr('checked');
    	if(status == "checked") {
            $("#flipbox_question").html(question_content + answer_content);
            $( "#flipbox_question" ).effect('slide');
        } else {
            $("#flipbox_question").html(question_content);
            $( "#flipbox_question" ).effect('slide');
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
    if(hidden_counter > count) {
        var hidden_counter_plus_one = hidden_counter - 1;
        $("#hidden_counter").val(hidden_counter_plus_one);
        var question_content = $("#question_"+hidden_counter_plus_one).html();
        var answer_content = $("#answer_"+hidden_counter_plus_one).html();
        $("#flipbox_question").html(question_content + answer_content);
        var status = $("#both_sides").attr('checked');
        if(status == "checked") {
            $("#flipbox_question").html(question_content + answer_content);
            $( "#flipbox_question" ).effect('slide');
        } else {
            $("#flipbox_question").html(question_content);
            $( "#flipbox_question" ).effect('slide');
        }
        /*$("#flipbox_question").flip({
        	color: '#dfcbb0',
        	direction: 'bt',
            content: question_content,//(new Date()).getTime(),
            onBefore: function(){$(".revert").show()}
        })
        $("#flipbox_answer").flip({
            color: '#dfcbb0',
            direction: 'bt',
            content: answer_content,//(new Date()).getTime(),
            onBefore: function(){$(".revert").show()}
        })*/
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
            onBefore: function(){$(".revert").show()}
        })
    } else {
        $("#question_answer").val('1');
        var question_content = $("#question_"+hidden_counter).html();
        $("#flipbox_question").flip({
            color: '#fafafa',
            direction: 'rl',
            content: question_content,//(new Date()).getTime(),
            onBefore: function(){$(".revert").show()}
        })
    }    
        return false;
    
}
</script> 