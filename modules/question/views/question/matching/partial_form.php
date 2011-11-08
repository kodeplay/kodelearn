<h2 class="h4 bold">Add matched pairs.</h2>
<ol class="form-assist">    
    <li>Add correctly matched pairs below</li>
    <li>While showing it to the students, it will be randomly shuffled.</li>    
</ol>
<?php if ($error_matched_pairs) {  ?>
<div class="formMessages w90">     
    <span class="fmIcon bad"></span> <span class="fmText" ><?php echo $error_matched_pairs; ?></span>
    <span class="clear">&nbsp;</span>
</div>
<?php } ?>
<ul id="matched-items" class="form-blocks tm40 w90">
    <?php if ($attribute['pairs']) { ?>
    <?php foreach ($attribute['pairs'] as $pair) { ?>
    <li>
        <input type="text" name="attributes[pairs][l][]" value="<?php echo $pair[0]; ?>" />&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" name="attributes[pairs][r][]" value="<?php echo $pair[1]; ?>"/>
        <div class="rm-block">x</div>
    </li>
    <?php } ?>
    <?php } else { ?>
    <li>
        <input type="text" name="attributes[pairs][l][]" />&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" name="attributes[pairs][r][]" />
        <div class="rm-block">x</div>
    </li>
    <li>
        <input type="text" name="attributes[pairs][l][]" />&nbsp;&nbsp;&nbsp;&nbsp;
        <input type="text" name="attributes[pairs][r][]" />
        <div class="rm-block">x</div>
    </li>
    <?php } ?>
</ul>
<a id="add-pair-btn" class="button r tm5">Add one</a>
<table class="tm40 pad5cells w90">
    <tr>
        <td class="vatop"><label><?php echo __('Explanation'); ?></label></td>
        <td><textarea name="attributes[explain]" class="w90"><?php echo $attribute['explanation']; ?></textarea></td>        
    </tr>
</table>
<script type="text/javascript">
$(document).ready(function () { 
    new KODELEARN.helpers.Formblocks({
        listElem: '#matched-items',
        itemElem: '#matched-items>li',  
        addBtn: '#add-pair-btn',
        min: 2,
        tmpl: '<li><input type="text" name="attributes[pairs][l][]" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="text" name="attributes[pairs][r][]" /><div class="rm-block">x</div></li>'        
    });
});

</script>
