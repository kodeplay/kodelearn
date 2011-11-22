<table>
    <tr>
        <th class="tal"><?php echo __('Choice'); ?></th>
        <th class="tac"><?php echo __('Correct'); ?></th>
        <th class="tal"><?php echo __('Explanation'); ?></th>
        <th class="tac"><?php echo __('Your Answer'); ?></th>
    </tr>
    <?php foreach ($choices as $choice) { ?>
    <tr>
        <td class="tal"><?php echo $choice['choice']; ?></td>
        <td class="tac"> 
            <?php  if ($choice['correctness']) { ?>
                <span class="tGreen"><?php echo __('Yes'); ?></span>
            <?php } else { ?>
                <span class="tRed"><?php echo __('No'); ?></span>
            <?php } ?>
        </td>
        <td class="tal"><?php echo $choice['explanation']; ?></td>
        <td class="tac">
            <?php  if ($choice['answered']) { ?>
                <span class="tGreen"><?php echo __('Yes'); ?></span>
            <?php } else { ?>
                <span class="tRed"><?php echo __('No'); ?></span>
            <?php } ?>
        </td>
    </tr>
    <?php } ?>
</table>
