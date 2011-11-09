<p class="question-help">Drag items to arrange in the correct answer.</p>
<ul class="pairs-matching-section items-left l">
    <?php foreach ($lefts as $left) { ?>
        <li>
            <?php echo $left; ?>
            <input type="hidden" name="left[]" value="<?php echo $left; ?>" />
        </li>    
    <?php } ?>
</ul>
<ul class="pairs-matching-section items-right r">
    <?php foreach ($rights as $right) { ?>
        <li>
            <?php echo $right; ?>
            <input type="hidden" name="left[]" value="<?php echo $right; ?>" />
        </li>    
    <?php } ?>
</ul>
<script type="text/javascript">
    $(".items-right").sortable();
</script>
