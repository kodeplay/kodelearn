<?php if ($preview) {  ?>
<div class="formMessages w90">     
    <span class="fmIcon bad"></span> <span class="fmText" ><?php echo __('This is preview and hence the answer cannot be submitted'); ?></span>
    <span class="clear">&nbsp;</span>
</div>
<?php } ?>
<div id="questions-left">
    <div class="question-block">
        <h3>Q. <?php echo $question->question; ?></h3>
        <p><?php echo $question->extra; ?></p>
        <div class="answer-section">
            <?php echo $answer_template; ?>
        </div>    
    </div>
</div>
<ul id="questions-right">
    <li>
        <h4>Hints</h4>
        <div>
            <span class="vpad5 h5">Hints reduce your points so try to avoid them as far as possible.</span>
            <ul class="vpad5 lh160 tm10">
                <?php if ($hints) { ?>
                    <?php foreach ($hints as $key=>$hint) { ?>
                        <li><a href="">Take hint #<?php echo ($key+1); ?></a> <span class="red">(-<?php echo $hint['deduction']; ?>%)</span></li>
                    <?php } ?>
                <?php } ?>
            </ul>        
        </div>
    </li>
</ul>
