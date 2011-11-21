<h4 class="h4"><?php echo __('Your Answer'); ?></h4>
<ol class="pad5 lsPosIn">
    <?php foreach ($answer['submitted_order'] as $item) { ?>
        <li><?php echo $item; ?></li>
    <?php } ?>
</ol>
<h4 class="h4"><?php echo __('Correct Order'); ?></h4>
<ol class="pad5 lsPosIn">
    <?php foreach ($answer['correct_order'] as $item) { ?>
        <li><?php echo $item; ?></li>
    <?php } ?>
</ol>
<p class="vpad5"><?php echo __('Explanation: '); ?><?php echo $answer['explanation']; ?></p>
