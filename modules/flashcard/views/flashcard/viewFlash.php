    <div class="r pagecontent">
        <div class="pageTop withBorder">
            <div class="pageTitle l w60">replace_here_page_title</div>
            <div class="pageDesc r">replace_here_page_description</div>
            <div class="clear"></div>
        </div><!-- pageTop -->
        <div style="margin-top: 10px; margin-left:10px;">
            <div class = "flipbox" id="flipbox_question" style="float: left;"></div>
            <div style="float: left; margin: 30px; padding-left: 5px; padding-top: 60px;">
                <a class="button" onclick="flipAnswer();" style="width: 80px; text-align: center;">Flip</a>
            </div>
            <div class="clear"></div>
            <?php if($questions) { ?>
                <?php $i= "1"; ?>
                <?php foreach($questions as $question) { ?>
                    <div id="question_<?php echo $i; ?>" style="display: none;">
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
        <div style="margin-top: 10px; width: 370px; margin-left:10px;">
            <a id="previous" class="" onclick="getPrevious();" style="float: left; cursor: pointer; font-weight: bold;"><< Previous</a>
            <a id="next" class="" onclick="getNext();" style="float: right; cursor: pointer; font-weight: bold;">Next >></a>
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
    $("#flipbox_question").html("");
    $("#flipbox_question").html(question_content);
    $("#question_answer").val('1');
    /*$("#flipbox_question").flip({
        color: '#dfcbb0',
        content: question_content,//(new Date()).getTime(),
        onBefore: function(){$(".revert").show()}
    })*/
    return false;
});

function getNext() {
    var count = "<?php echo count($questions); ?>";
    var hidden_counter = parseInt($("#hidden_counter").val());
    if(hidden_counter < count) {
        var hidden_counter_plus_one = hidden_counter + 1;
        $("#hidden_counter").val(hidden_counter_plus_one);
        var question_content = $("#question_"+hidden_counter_plus_one).html();
        $("#flipbox_question").fadeOut(200);
        $("#flipbox_question").html("");
        $("#flipbox_question").fadeIn(200);
        $("#flipbox_question").html(question_content);
        $("#question_answer").val('1');
        /*$("#flipbox_question").flip({
            color: '#dfcbb0',
            direction: 'tb',
            content: question_content,//(new Date()).getTime(),
            onBefore: function(){$(".revert").show()}
        })*/
        
        return false;
    } else {
        return false;
    }
}

function getPrevious() {
    var count = "1";
    var hidden_counter = parseInt($("#hidden_counter").val());
    if(hidden_counter > count) {
        var hidden_counter_plus_one = hidden_counter - 1;
        $("#hidden_counter").val(hidden_counter_plus_one);
        var question_content = $("#question_"+hidden_counter_plus_one).html();
        $("#flipbox_question").fadeOut(200);
        $("#flipbox_question").html("");
        $("#flipbox_question").fadeIn(200);
        $("#flipbox_question").html(question_content);
        $("#question_answer").val('1');
        /*$("#flipbox_question").flip({
            color: '#dfcbb0',
            direction: 'bt',
            content: question_content,//(new Date()).getTime(),
            onBefore: function(){$(".revert").show()}
        })*/
        
        return false;
    } else {
        return false;
    }
}

function flipAnswer() {
	var question_answer = $("#question_answer").val();
	var hidden_counter = parseInt($("#hidden_counter").val());
	if(question_answer == '1') {
		$("#question_answer").val('0');
        var answer_content = $("#answer_"+hidden_counter).html();
        $("#flipbox_question").flip({
            color: '#dfcbb0',
            direction: 'lr',
            content: answer_content,//(new Date()).getTime(),
            onBefore: function(){$(".revert").show()}
        })
	} else {
		$("#question_answer").val('1');
        var question_content = $("#question_"+hidden_counter).html();
        $("#flipbox_question").flip({
            color: '#dfcbb0',
            direction: 'rl',
            content: question_content,//(new Date()).getTime(),
            onBefore: function(){$(".revert").show()}
        })
	}    
        return false;
    
}

</script> 