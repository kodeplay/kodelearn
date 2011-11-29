<div id="quiz-page" class="hidden">
    <div id="questions-left">
        <div class="question-block">
              
        </div>
    </div>        
    <ul id="questions-right">
        <li>
            <h4>Your Answer</h4>
            <div>
                <a class="button tm10" id="submit-answer">Submit Answer</a>
                <p class="h2 tm10" id="question-result"></p>                        
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
<script type="text/javascript">
KODELEARN.modules.add('quiz', (function () {

    return {
        
        progress:  [],
        
        current: {},
        
        questions: [],
                    
	    init: function () {
	        var self = KODELEARN.modules.get('quiz');
	        $("#start-exercise").click(function () { 
                $("#exercise-instructions").hide();
                $("#quiz-page").show();                
                self.firstQuestion();
            });	   
            $("#submit-answer").click(function () { 
                self.submitAnswer();
            });    
            $("#show-results").live('click', function () {
                self.showResults();            
            });
	    },
	    
	    firstQuestion: function () {	        
	        if (!this.progress[0]) {
	            this.nextQuestion();
	        }
	    },
	    
	    nextQuestion: function () {
	    
	        var reset = function () {
	            $("#next-question").hide();
                $("#submit-answer").show();                
                $("#question-result").text('').removeClass('tGreen tRed');
	        }
	    	        
	        var that = this;
	        $.ajax({
	            url: KODELEARN.config.base_url+'exercise/ajax_next_question/',
	            dataType: 'json',	            
	            success: function (resp) {
	                if (resp.status == 404) {
	                    alert('no question found');
	                    return false;
	                } 	  
	                reset();              
	                $(".question-block").html(resp.html);	
	                that.current = {
        	            question_id: resp.question_id,
	                    type: resp.type,
	                    answered: 0,
	                    correct: 0
	                };
	                that.questions.push(that.current);	
	                that.hints.init(resp.question_id, resp.num_hints);                             	            
	            }
	        });	        
	    },
	    
	    hints: {
	        question_id: null,
	    
	        init: function (question_id, num_hints) {
	            this.question_id = question_id;
	            if (!num_hints) {
                    this.deactivate();
                } else {
                    this.activate(num_hints);
                }
	        },
	    
	        activate: function (num_hints) {
	            $("#question-hints").show();
	            for (i=1; i<=num_hints; i++) {	                
	                $("#question-hints>div").append('<a class="button tm10" rel="'+i+'">Take Hint #'+i+'</a>');
	            }
	            var that = this;
	            $("#question-hints>div>a.button").live('click', function () {
	                var elem = this;
                    $.get(KODELEARN.config.base_url+'exercise/ajax_next_hint/question_id/'+that.question_id, function (resp) {
	                    if (resp.status == 1) {
	                        var num = $(elem).attr('rel');
	                        $(elem).replaceWith('<p class="tm10">Hint #'+num+' '+resp.hint+'</p>');
	                    } else {
	                        alert('something wrong happened!');
	                    }
	                }, 'json');                 
                });
	        },
	        
	        deactivate: function () {
	            $("#question-hints>div").children().filter('a.button').remove();
	            $("#question-hints").hide();
	        }    
	    },
	    
	    // submit the answer and get the result
	    submitAnswer: function () {
	        // ajax request
	        var answer = this.formatAnswer(),
	        that = this;
	        // console.log(answer);
	        $.ajax({
	            url: KODELEARN.config.base_url+'exercise/ajax_submit_answer/',
	            dataType: 'json',
	            type: 'POST',
	            data: { 'answer': answer, 'question_id': this.current.question_id },
	            success: function (resp) {
	                if (resp.status === 1) {	                    
	                    if (resp.result === 1) {
	                        $("#question-result").text('Correct!').addClass('tGreen');
	                    } else {
    	                    $("#question-result").text('Wrong!').addClass('tRed');
	                    }
	                    that.showProgress(resp.progress);	                    
	                } else {
	                    alert('Oops! Something went wrong!');
	                }
	            }
	        });	        
	        // change submit answer button to next question
	        this.current.answered = 1;
	        $("#submit-answer").after('<a class="button" id="next-question" onclick="KODELEARN.modules.get(\'quiz\').nextQuestion()">Next Question</a>').hide();
	    },
	    
	    showProgress: function (progress) {
	        if (!$("#ex-progress").length) {
    	        $("#questions-right").prepend('<li id="ex-progress"><h4>Your Progress</h4><div></div></li>');
	        }
	        this.progress.push(progress)
	        $("#ex-progress>div").text(progress);
	        // check if it was the last question and change the next question button to view results
	        var p = progress.split('/');	        
	        if (p[0] == p[1]) {
	            this.onComplete();
	        }
	    },
	    
	    // when all questions have been answered
	    onComplete: function () {	        
    	    $("#submit-answer").remove();  
	        $("#next-question").replaceWith('<a class="button" id="show-results">Show Results</a>');
            $("#ex-progress>div").append('<p class="tm10 tGreen">Exercise Complete!</p>');
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
	    },
	    
	    showResults: function () {
	        window.location = KODELEARN.config.base_url+'exercise/results/';    
	    }
    };        
})());
</script>
