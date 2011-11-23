<h4 class="h4"><?php echo __('Your Answer'); ?></h4>

<?php if ($answer['submitted_order']) { ?> 
    <ol class="pad5 lsPosIn">   
    <?php foreach ($answer['submitted_order'] as $item) { ?>
        <li><?php echo $item; ?></li>
    <?php } ?>
    </ol>
<?php } else { ?>
    <p class="vpad10 tRed"><?php echo __('Not Attempted'); ?></p>
<?php } ?>    

<h4 class="h4"><?php echo __('Correct Order'); ?></h4>
<ol class="pad5 lsPosIn">
    <?php foreach ($answer['correct_order'] as $item) { ?>
        <li><?php echo $item; ?></li>
    <?php } ?>
</ol>
<p class="vpad5"><?php echo __('Explanation: '); ?><?php echo $answer['explanation']; ?></p>
