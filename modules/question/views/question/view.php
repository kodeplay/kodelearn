<div class="r pagecontent">
    <div class="pageTop">
        <div class="pageTitle l">replace_here_page_title</div>
        <div class="pageDesc r">replace_here_page_description</div>
        <div class="clear"></div>
    </div><!-- pageTop -->     
     
    <?php if ($preview) {  ?>
    <div class="formMessages w90">     
        <span class="fmIcon bad"></span> <span class="fmText" ><?php echo __('This is preview and hence the answer cannot be submitted'); ?></span>
        <span class="clear">&nbsp;</span>
    </div>
    <?php } ?>
    <div id="questions-left">
        <div class="question-block">
            <?php echo $question_partial; ?>     
        </div>
    </div>
    <ul id="questions-right">
        <?php if ($hints) { ?>
        <li>
            <h4>Hints</h4>
            <div>
                <span class="vpad5 h5">Hints reduce your points so try to avoid them as far as possible.</span> <br/><br/>
                <a onclick="$('#hint-list').removeClass('hidden')" class="button">Take Hint</a>
                <ul class="tm10 hidden" id="hint-list">
                <?php foreach ($hints as $k=>$hint) { ?>
                    <li>
                        <a href="javascript:void(0);"><?php echo __('Hint #'.($k+1)); ?></a>
                        <input type="hidden" name="hint_text_<?php echo $k+1; ?>" value="<?php echo $hint['hint']; ?>" />
                        <input type="hidden" name="hint_dedn_<?php echo $k+1; ?>" value="<?php echo $hint['deduction']; ?>" />
                    </li>
                <?php } ?>                       
                </ul>
            </div>
        </li>
        <?php } ?>
    </ul>
    
    </div><!-- content -->
    
    <div id="hint-preview-dialog"></div>

<div class="clear"></div>   
<script type="text/javascript">
$(document).ready(function () {
    $("#hint-preview-dialog").dialog({
        autoOpen: false,
        close: function () {
            $(this).html('');
        }
    });
    $("#hint-list>li>a").click(function () {
        var $hidden = $(this).siblings()
        hint = $hidden.filter("input[name^='hint_text_']").val(),
        deduction = $hidden.filter("input[name^='hint_dedn_']").val();
        $("#hint-preview-dialog").append('<h3 class="h3">'+hint+'</h3>').dialog('open');
    });
});
</script>
