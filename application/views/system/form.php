<div class="r pagecontent">
    <div class="pageTop">
        <div class="pageTitle l">replace_here_page_title</div>
        <div class="pageDesc r">replace_here_page_description</div>
        <div class="clear"></div>
    </div><!-- pageTop -->
    
    <div class="topbar">
        <a href="#" class="pageTab active">General</a>
        <!-- <a href="#" class="pageTab">Languages</a> -->
        <?php if (Acl::instance()->has_access('location')) { ?>
            <?php echo HTML::anchor('location','Locations and Rooms', array('class' => 'pageTab')); ?>
        <?php }?>
    </div><!-- topbar -->
    
    <?php echo $form->startform(); ?>
        <table class="formcontainer">
            <tr>
                <td><label for="insti"><?php echo $form->name->label(); ?></label></td>
                <td><?php echo $form->name->element(); ?>
                <span class="form-error"><?php echo $form->name->error(); ?></span></td>
            </tr>
            <tr>
                <td><label for="instiType"><?php echo $form->institutiontype_id->label(); ?></label></td>
                <td>
                    <?php echo $form->institutiontype_id->element(); ?>
                </td>
            </tr>
            <tr>
                <td class="topAlign">
                    <?php echo $form->logo->label(); ?>
                    <p class="tip">Preferred size: 100px</p>
                </td>
                <td><img src="<?php echo $image ?>" alt="" id="photo" />
                <input style="font-size:12px;" type="button" id="uploadinst" value="Upload"><?php echo $form->logo->element(); ?></td>
            </tr>
            <tr>
                <td><label for="instiURL"><?php echo $form->website->label(); ?></label></td>
                <td><?php echo $form->website->element(); ?></td>
            </tr>
            <tr>
                <td class="topAlign"><label for="instiAddr"><?php echo $form->address->label(); ?></label></td>
                <td>
                    <?php echo $form->address->element(); ?>
                </td>
            </tr>
            <tr>
                <td><label for="lang"><?php echo $form->config_language_id->label(); ?></label></td>
                <td>
                    <?php echo $form->config_language_id->element(); ?>
                </td>
            </tr>
            <tr>
                <td><label for="membership"><?php echo $form->config_membership->label(); ?></label></td>
                <td>
                    <?php echo $form->config_membership->element(); ?> <label for="membership">Anyone can register</label>
                </td>
            </tr>
            <tr>
                <td><label for="roleStudent"><?php echo $form->config_default_role->label(); ?></label></td>
                <td class="topAlign">
                    <?php echo $form->config_default_role->element(); ?>
                </td>
            </tr>
            <tr>
                <td class="topAlign"><label for="uarYes"><?php echo $form->config_user_approval->label(); ?></label></td>
                <td>
                     <?php echo $form->config_user_approval->element(); ?>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><?php echo $form->save->element(); ?></td>
            </tr>
        </table>
    <?php echo $form->endForm(); ?>
    
</div><!-- pagecontent -->

<div class="clear"></div>

<script type="text/javascript"><!--
new AjaxUpload('#uploadinst', {
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
            $('input[name=logo]').attr('value',data.filename);
            //$('image').val(data.filename);  
        } else {
           $('#uploadinst').after('<span class="form-error">' + data.errors.image + '</span>'); 
        }
    }
});

//--></script>