<h2 class="h4 bold">Add items/statements in their correct order.</h2>
<ol class="form-assist">    
    <li>Add your statements in the correct order. The user will see them randomly shuffled.</li>
    <li>Drag and Drop to rearrange</li>
    <li>Please add an explanation as to why this is the correct order</li>
</ol>
<?php if ($error_ordered_items) {  ?>
<div class="formMessages w90">     
    <span class="fmIcon bad"></span> <span class="fmText" ><?php echo $error_ordered_items; ?></span>
    <span class="clear">&nbsp;</span>
</div>
<?php } ?>
<ul id="ordered-items" class="form-blocks tm40">
    <?php if ($attribute['items']) { ?>
    <?php foreach ($attribute['items'] as $item) { ?>
    <li>
        <input type="text" name="attributes[items][]" value="<?php echo $item; ?>" />
        <div class="rm-block">x</div>
    </li>    
    <?php } ?>
    <?php } else { ?>
    <li>
        <input type="text" name="attributes[items][]" />
        <div class="rm-block">x</div>
    </li>
    <?php } ?>
</ul>
<a id="add-item-btn" class="button r tm5">Add one</a>
<table class="tm40 pad5cells w90">
    <tr>
        <td class="vatop"><label><?php echo __('Explanation'); ?></label></td>
        <td><textarea name="attributes[explain]" class="w90"><?php echo $attribute['explanation']; ?></textarea></td>        
    </tr>
</table>
<script type="text/javascript">
$(document).ready(function () {
    $("#ordered-items>li").live('mouseover mouseout', function (event) {                 
        if (event.type == 'mouseover') {               
            if ($(this).siblings().length > 0) { 
                $(this).children().filter('.rm-block').show();
            }
        } else if (event.type == 'mouseout') {
            $(this).children().filter('.rm-block').hide();
        }
    });
    $("#ordered-items").sortable();
    $("#add-item-btn").click(function () {
        $("#ordered-items").append('<li><input type="text" name="attributes[items][]" /><div class="rm-block">x</div></li>');
    });
});

</script>
