<h3>Q.<?php echo $idx; ?> <?php echo $question->question; ?></h3>
<p><?php echo $question->extra; ?></p>
<div class="answer-section">
    <?php echo $answer_template; ?>
</div>
<?php if ($has_math_expr) { ?>
<script type="text/javascript">
    MathJax.Hub.Typeset();  
</script>
<?php } ?>
