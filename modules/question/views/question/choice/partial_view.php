<ul class="choice-section">
    <?php foreach ($choices as $choice) { ?>
        <li>           
            <?php if ($choice_type === 'unique') { ?>
                <input type="radio" name="selected[]" />
            <?php } elseif ($choice_type === 'multiple') { ?>
                <input type="checkbox" name="selected[]" />
            <?php } ?>
            <?php echo $choice['attribute_value']; ?>
            <input type="hidden" value="<?php echo $choice['attribute_value']; ?>" />
        </li>    
    <?php } ?>
</ul>
