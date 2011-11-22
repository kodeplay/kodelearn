<div class="r pagecontent">
    <div class="pageTop withBorder">
        <div class="pageTitle l w60"><?php echo $quiz['title']; ?></div>
        <div class="pageDesc r">replace_here_page_description</div>
        <div class="clear"></div>
    </div><!-- pageTop -->    
    
    <div class="tm40" id="quiz-instructions" style="min-height: 80px;">
        <?php echo $quiz['instructions']; ?>
        <br/> <br/> <br/>        
        <a class="button" id="start-quiz">Start Quiz</a> 
    </div>
    <div id="quiz-page" class="hidden">
        <div id="questions-left">
            <div class="question-block">
                  
            </div>
        </div>        
        <ul id="questions-right">
            <li>
                <h4>Your Answer</h4>
                <div>
                    <a class="button" id="submit-answer">Submit Answer</a>                        
                </div>
            </li>
            <li id="question-hints">
                <h4>Hints</h4>
                <div>
                    <span class="vpad5 h5">Hints reduce your points so try to avoid them as far as possible.</span>                        
                </div>
            </li>
        </ul>
    </div>    
</div><!-- content -->

<div class="clear"></div>
<script type="text/javascript" src="<?php echo URL::base() ?>media/javascript/spine.js"></script>
<script type="text/javascript">
KODELEARN.modules.add('quiz', (function () {

    return {
        
        progress:  [],
        
        current: {},
        
        questions: [],
                    
	    init: function () {
	        var self = KODELEARN.modules.get('quiz');
	        $("#start-quiz").click(function () { 
                $("#quiz-instructions").hide();
                $("#quiz-page").show();                
                self.firstQuestion();
            });	   
            $("#submit-answer").click(function () { 
                self.submitAnswer();
            });     
	    },
	    
	    firstQuestion: function () {	        
	        if (!this.progress[0]) {
	            this.nextQuestion();
	        }
	    },
	    
	    nextQuestion: function () {	        
	        var that = this;
	        $.ajax({
	            url: KODELEARN.config.base_url+'quiz/question/',
	            dataType: 'json',	            
	            success: function (resp) {
	                if (resp.status == 404) {
	                    alert('no question found');
	                    return false;
	                } 	                
	                $(".question-block").html(resp.html);
	                $("#next-question").hide();
	                $("#submit-answer").show();
	                if (!resp.num_hints) {
	                    $("#question-hints").hide();
	                } else {
	                    $("#question-hints").show();
	                }
	                that.current = {
        	            question_id: resp.question_id,
	                    type: resp.type,
	                    answered: 0,
	                    correct: 0
	                };
	                that.questions.push(that.current);	                             	            
	            }
	        });	        
	    },
	    
	    // submit the answer and get the result
	    submitAnswer: function () {
	        // ajax request
	        var answer = this.formatAnswer();
	        console.log(answer);
	        $.ajax({
	            url: KODELEARN.config.base_url+'quiz/answer/',
	            dataType: 'json',
	            type: 'POST',
	            data: { 'answer': answer, 'question_id': this.current.question_id },
	            success: function (resp) {
	            
	            }
	        });
	        // change submit answer button to next question
	        this.current.answered = 1;
	        $("#submit-answer").after('<a class="button" id="next-question" onclick="KODELEARN.modules.get(\'quiz\').nextQuestion()">Next Question</a>').hide();
	    },
	    
	    // format the answer in the correct form to be submitted for checking
	    formatAnswer: function () {
	        var answer = [];
	        switch (this.current.type) {
	        case "choice":
	            $("input[name='selected[]']:checked").each(function () { 
	                answer.push($(this).siblings().filter("input[type='hidden']").val());
	            });
	            break;
	        case "open":
	            answer = $("input[name='answer']").val();
	            break;
	        case "ordering":
	            $(".answer-section>ul>li").each(function () {
	                answer.push($(this).children().filter("input[type='hidden']").val());    
	            });
	            break;
	        case "matching":	            
	            $(".items-left>li").each(function () {	                
	                var left = $(this).children().filter("input[type='hidden']").val();    
	                var right = $(this).parent().siblings().filter("ul.items-right").children().eq($(this).index()).children().filter("input[type='hidden']").val();
	                answer.push([left, right]);
	            });	            
	            break;
	        }
	        return answer;	    
	    }
    };
        
})());
</script>
