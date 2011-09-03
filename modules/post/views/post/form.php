<div class="clear">
<div class="pad10 tm10" id="post-form">
    <label>Post something: </label>
    <textarea></textarea>
    <a class="button r">Post</a>
    <div class="clear"></div>
    <p class="vpad10 tm10">
        Share with: &nbsp;
        <select>
            <?php foreach ($visibility_options as $key=>$option) { ?>
                <option value="<?php echo $key; ?>"><?php echo $option; ?></option>
            <?php } ?>
        </select>    
    </p>    
   
</div>
