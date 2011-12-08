    <div class="r pagecontent">
        <div class="pageTop withBorder">
            <div class="pageTitle l w60">replace_here_page_title</div>
            <div class="pageDesc r">replace_here_page_description</div>
            <div class="clear"></div>
        </div><!-- pageTop -->
        <?php echo $form->startform(); ?>
        <table class="formcontainer bm40" style="width: 60%;">
            <tr>
                <td><?php echo $form->title->label(); ?></td>
                <td><?php echo $form->title->element(); ?>
                <span class="form-error"><?php echo $form->title->error(); ?></span></td>
            </tr>
            <tr>
                <td class="vatop"><?php echo $form->description->label(); ?></td>
                <td><?php echo $form->description->element(); ?>
                <span class="form-error"><?php echo $form->description->error(); ?></span></td>
            </tr>
            <tr>
                <td class="vatop"><?php echo $form->url->label(); ?></td>
                <td><?php echo $form->url->element(); ?>
                <span class="form-error"><?php echo $form->url->error(); ?></span></td>
            </tr>
            <tr>
                <td class="vatop"><?php echo $form->image->label(); ?></td>
                <td><?php echo $form->image->element(); ?>
                <span class="form-error"><?php echo $form->image->error(); ?></span></td>
            </tr>
            <tr>
                <td>
                    <label for="photo">Image</label>
                </td>
                <td><img src="<?php echo $image ?>" alt="" id="photo" />
                    <input style="font-size:12px;" type="button" id="uploadlinkimg" value="Upload">
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <?php echo $form->save->element(); ?>
                    <span class="r">
                        <?php echo $links['cancel']?>
                    </span>
                </td>
            </tr>
        </table>
       
        
        
        
         <?php echo $form->endForm(); ?>
        
        
    </div><!-- content -->
    
    <div class="clear"></div>
<script type="text/javascript"><!--
new AjaxUpload('#uploadlinkimg', {
    action : '<?php echo $upload_url ?>',
    name : 'image',
    autoSubmit : true,
    responseType: 'json',
    onChange: function(file, extension){   },   
    onSubmit: function(file, extension) {
        //alert('submiting');
    },
    onComplete: function(file, data) {
        
        if(data.success){
            $('#photo').attr('src',data.image);
            $('input[name=image]').attr('value',data.image);
        } else {
           $('#uploadlinkimg').after('<span class="form-error">' + data.errors.image + '</span>'); 
        }
    }
});

//--></script>