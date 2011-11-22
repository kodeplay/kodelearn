<h4 class="h4"><?php echo __('Your Answer'); ?></h4>
<?php if ($answer['submitted_pairs']) { ?>
    <table class="pad5 w60">
        <?php foreach ($answer['submitted_pairs'] as $item) { ?>
        <tr>
            <td><?php echo $item[0]; ?></td>
            <td><?php echo $item[1]; ?></td>
        </tr>
        <?php } ?>
    </table>
<?php } else { ?>
    <p class="vpad10 tRed"><?php echo __('Not Attempted'); ?></p>
<?php } ?>
<h4 class="h4"><?php echo __('Correct Order'); ?></h4>
<table class="pad5 w60">
    <?php foreach ($answer['matched_pairs'] as $item) { ?>
    <tr>
        <td><?php echo $item[0]; ?></td>
        <td><?php echo $item[1]; ?></td>
    </tr>
    <?php } ?>
</table>
<p class="vpad5"><?php echo __('Explanation: '); ?><?php echo $answer['explanation']; ?></p>
