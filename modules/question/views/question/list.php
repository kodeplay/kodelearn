<div class="r pagecontent">
    <div class="pageTop">
        <div class="pageTitle l">replace_here_page_title</div>
        <div class="pageDesc r">replace_here_page_description</div>
        <div class="clear"></div>
    </div><!-- pageTop -->        
    
    <div class="topbar" style="position: relative">
        <?php if (Acl::instance()->is_allowed('question_delete')) { ?>
        <a onclick="$('#question').submit();" class="pageAction r alert">Delete selected...</a>
        <?php } ?>  
        <?php if (Acl::instance()->is_allowed('question_create')) { ?>
        <?php echo $links['add']; ?>
        <ul id="question-type-selector">    
            <li>Select question type</li>
            <?php foreach ($types as $type) { ?>
            <li rel="<?php echo $type; ?>"><?php echo $type; ?></li>
            <?php } ?>
        </ul>
        <?php } ?>        
        <!--  <a href="#" class="pageAction c">Send message</a>-->
        <span class="clear">&nbsp;</span>
    </div><!-- topbar -->
    <?php if ($success) {  ?>
        <div class="formMessages w90">     
        <span class="fmIcon good"></span> <span class="fmText" ><?php echo $success ?></span>
        <span class="clear">&nbsp;</span>
        </div>
    <?php } ?>
    
    
    <form name="question" id="question" method="POST" class="selection-required" action="<?php echo $links['delete'] ?>">
    
    <table class="vm10 datatable fullwidth">
        <?php echo $table['headings'] ?>
        <?php foreach($table['data'] as $question){ ?>
        <tr>
            <td><input type="checkbox" class="selected" name="selected[]" value="<?php echo $question->id ?>" /></td>
            <td><?php echo $question->question; ?></td>
            <td><?php echo $question->type; ?></td>            
            <td>
                <p>
                <?php echo Html::anchor('/question/preview/id/'.$question->id, 'Preview')?> 
                <?php if (Acl::instance()->is_allowed('question_edit')) { 
                    echo '/ ' . Html::anchor('/question/edit/id/'.$question->id, 'Edit');
                } ?>
                </p>
            </td>
        </tr>
        <?php }?>
        <?php if($total == 0){ ?>
            <tr>
                <td colspan="6" align="center">
                    No Records Found
                </td>
            </tr>
        <?php } ?>        
    </table>
    </form>
</div><!-- content -->

<div class="clear"></div>   
<script type="text/javascript">
KODELEARN.modules.add('question', (function () {
    return {
        init: function () { 
            var location = $(".createButton").attr('href');  
            $(".createButton").click(function (e) { 
                e.preventDefault();
                $("#question-type-selector").slideDown(200);                 
            });
            $("body").click(function (e) { 
                var $target = $(e.target);   
                if (!$target.is("#question-type-selector") && 
                    !$target.is(".createButton") &&
                    $target.parents("#question-type-selector").length == 0) {
                    $("#question-type-selector").slideUp(200);
                }
            });
            $("#question-type-selector>li").click(function () {
                var type = $(this).attr('rel');
                if(type) {
                    window.location.href = location + '/type/' + type;
                }
            });
        }
    };
})());

</script> 
