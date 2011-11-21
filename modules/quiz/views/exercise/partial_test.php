<div id="test-page" class="hidden">
    <ul class="tm40">    
        <?php foreach ($questions as $question) { ?>
            <li id="q-<?php echo $question->orm()->id; ?>" class="tm10 pad10"><?php echo $question->render_question(); ?></li>
        <?php } ?>
    </ul>
    <div id="test-right">
        <a class="button" id="btn-submit-test"><?php echo __('Submit Test'); ?></a> 
        <div id="test-ques-board">           
            <table style="width: 100%;">
                <thead>
                    <tr>
                        <th><?php echo __('Question'); ?></td>
                        <th><?php echo __('Attempted'); ?></th>
                        <th><?php echo __('Bookmark'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="3">
                            <div style="width: 100%; height: 300px; overflow-y: auto;">
                                <table style="width: 100%; ">
                                    <tbody>                                    
                                        <?php foreach ($questions as $question) { ?>
                                        <tr id="qb-<?php echo $question->orm()->id; ?>">
                                            <td><a href="javascript:void(0);" title="<?php echo $question->orm()->question; ?>">Q.<?php echo $question->idx(); ?></a></td>
                                            <td class="tRed">No</td>
                                            <td><input type="checkbox" /></td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>                    
                        </td>
                    </tr>
                </tbody>                
            </table>
        </div>
    </div>    
</div>
<script type="text/javascript">
KODELEARN.modules.add('test', (function () {

    return {
    
        exercise_id: <?php echo $exercise->id; ?>,
    
        // array of objects of the form { question_id: 1, type: 'ordering', answer: [] }
        responses: [],
                    
	    init: function () {
	        var that = this;	        
	        $("#start-exercise").click(function () { 
                $("#exercise-instructions").hide();
                KODELEARN.helpers.tmpl_manipulation.hideSidebar(true);
                $("#test-page").show();                
            });	   
            $("#btn-submit-test").click(function () { 
                that.submitTest();
            });
            // append text [Not Attempted] after all questions
            $("#test-page>ul>li>h3").after('<span class="bold tRed">[Not Attempted]</span>');
            // bookmarking of questions
            $("input[type='checkbox']", "#test-ques-board").change(function () { 
                var checked = $(this).attr('checked');
                if (!checked) {
                    $(this).parent().parent().removeClass('bookmarked-question');
                } else {
                    $(this).parent().parent().addClass('bookmarked-question');
                }
            });
            this.openBindings();
            this.choiceBindings();
            this.orderingBindings();
            this.matchingBindings();
	    },
	    
	    saveResponse: function (question_id, answer) {
	        question_id = parseInt(question_id);	        
	        var added = false;
	        for (i = 0; i < this.responses.length; i++) {
	            if (this.responses[i]['question_id'] === question_id) {
	                this.responses[i]['answer'] = answer;
	                added = true;
	                break;
	            }	            
	        }
	        if (!added) {
	            this.responses.push({ 'question_id': question_id, 'answer': answer });
	        }
	        // console.log(this.responses);
	        this.markAttempted(question_id);
	    },
	    
	    choiceBindings: function () {
	        var type = 'choice',
	        that = this;
	        $(".choice-section>li>input").change(function () {
	            var choices = [],
	            question_id = $(this).parent().parent().parent().parent().attr('id').split('-')[1];	            
	            $(this).parent().parent().children().each(function () {
	                if ($(this).children().filter("input:checked").length) {
    	                choices.push($(this).children().filter("input[type='hidden']").val());
	                }
	            });
	            that.saveResponse(question_id, choices); 
	        });    	    
	    },
	    
	    openBindings: function () {
	        var type = 'open',
	        that = this;
	        $("input[name='answer']").change(function () {
	            var question_id = $(this).parent().parent().attr('id').split('-')[1],
	            answer = $(this).val();
                that.saveResponse(question_id, answer);
	        });
	    },
	    
	    orderingBindings: function () {
	        var type = 'ordering',
	        that = this;	    
	        // destroy sortables first as its done in every tmpl
	        $(".items-ordering-section").sortable("destroy");
	        $(".items-ordering-section").sortable({
	            update: function () {
	                // console.log($(this));
	                var question_id = $(this).parent().parent().attr('id').split('-')[1],
	                order = [];
	                $(this).children().each(function () { 
	                    order.push($(this).children().filter("input[type='hidden']").val());
	                });	                
	                that.saveResponse(question_id, order);
	            }
	        });
	    },
	    	    
	    matchingBindings: function () {
	        var type = 'matching',
	        that = this;    
	        $(".items-right").sortable("destroy");
	        $(".items-right").sortable({
	            update: function () {
	                var $right = $(this),
	                $left = $(this).siblings().filter('.items-left'),
	                pairs = [],
	                question_id = $(this).parent().parent().attr('id').split('-')[1];
	                $right.children().each(function () {
	                    pairs.push(
	                        [$left.children().eq($(this).index()).children().filter("input[type='hidden']").val(),
	                        $(this).children().filter("input[type='hidden']").val()]);
	                });
	                that.saveResponse(question_id, pairs);
	            }
	        });
	    },
	    
	    submitTest: function () {
	        var responses = JSON.stringify(this.responses);
	        $.ajax({
	            url: KODELEARN.config.base_url+'exercise/ajax_test_submit/',
	            dataType: 'json',
	            type: 'POST',
	            data: { exercise_id: this.exercise_id, responses: this.responses },
	            success: function (resp) {
	                if (resp.status == 1) {
	                    window.location = KODELEARN.config.base_url+'exercise/results/'
	                }
	            }
	        });
	    },
	    
	    markAttempted: function (question_id) {
	        console.log($("#q-"+question_id));
	        $("#q-"+question_id).children().filter('.bold.tRed').replaceWith('<span class="bold tGreen">[Attempted]</span>');
	        $("#qb-"+question_id).children().eq(1).text('Yes').removeClass('tRed').addClass('tGreen');
	    }
    }
}) ());
</script>
