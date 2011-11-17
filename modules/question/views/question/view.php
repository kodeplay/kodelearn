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
        <li>
            <h4>Hints</h4>
            <div>
                <span class="vpad5 h5">Hints reduce your points so try to avoid them as far as possible.</span> <br/><br/>
                <a class="button">Take Hint</a>                       
            </div>
        </li>
    </ul>
    
    </div><!-- content -->

<div class="clear"></div>   
