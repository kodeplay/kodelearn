<div id="document_from" title="Edit Document">
	<form id="document_form" name="document">
		<input type="hidden" name="document_id" value="<?php echo $id ?>" />
		<table class="formcontainer bm40">
			<tr>
				<td> Title</td>
				<td> <input type="text" value="<?php echo $title ?>" name="title" /></td>
			</tr>
			<tr>
				<td>Access To</td>
				<td>
				<?php foreach($roles as $id=>$role){ ?>
					<input type="checkbox" value="<?php echo $id ?>" name="role[]" <?php echo (in_array($id, $roles_access)) ? 'checked="checked"' : '' ?> /> <?php echo $role ?> <br/>
				<?php }?>
				</td>
			</tr>
		</table>
	</form>
</div>
<script type="text/javascript">
    $(function() {
        $( "#document_from" ).dialog({
        	resizable: false,
            modal: true,
            width: 400,
            buttons: {
                "Save": function() {
        			KODELEARN.modules.get('document').save();
                },
                Cancel: function() {
                    $( this ).dialog( "destroy" );
                    $('#document_from').remove();
                }
            }

        });
    });
</script>
