<div class="pageTop withBorder hpad10">
    <div class="w60 pageTitle l">New User</div>
    <div class="w30 pageTitle l">Existing User</div>
</div><!-- pageTop -->
<?php echo $admin_approval; ?>
<div class="vpad40 l" id="suContainer">
    <p class="tdBlue bm40">Sign up and join KodeLearn Learning Management System</p>
    <?php echo $form_register; ?>
</div><!-- suContainer -->

<div class="vpad40 l" id="lContainer">
    <p class="tdBlue bm40">Login to learn online</p>
    <?php echo $login_message; ?>
        <?php echo $form_login->startform(); ?>
        <table class="formcontainer">
            <tr>
                <td class="tar"><?php echo $form_login->email->label(); ?></td>
                <td>
                    <?php echo $form_login->email->element(); ?>
                    <span class="form-error"><?php echo $form_login->email->error(); ?></span>
                </td>
            </tr>
            <tr>
                <td class="tar"><?php echo $form_login->password->label(); ?></td>
                <td>
                    <?php echo $form_login->password->element(); ?>
                    <span class="form-error"><?php echo $form_login->password->error(); ?></span>
                    <p><?php echo $links['forgot_password_link']; ?></p>
                </td>
            </tr>
            <tr>
                <td class="tar"></td>
                <td><?php echo $form_login->remember->element() ?>&nbsp;<?php echo $form_login->remember->label(); ?></td>
            </tr>
            <tr>
                <td class="tar"></td>
                <td><?php echo $form_login->login->element(); ?></td>
            </tr>
        </table>
        <?php echo $form_login->endform(); ?>
        <br>
        <div style="display:<?php echo $display; ?>;" id="forgot_password">
        <p class="tdBlue bm40"><a name="password_recovery">Forgot Password</a></p>
        <?php echo $display_success; ?>
        <?php echo $form_forgot_password->startform(); ?>
        <table class="formcontainer">
            <tr>
                <td class="tar"><?php echo $form_forgot_password->email->label(); ?></td>
                <td>
                    <?php echo $form_forgot_password->email->element(); ?>
                    <span class="form-error"><?php echo $form_forgot_password->email->error(); ?></span>
                </td>
            </tr>
            
            <tr>
                <td class="tar"></td>
                <td><?php echo $form_forgot_password->forgot_password->element(); ?></td>
            </tr>
        </table>
        <?php echo $form_forgot_password->endform(); ?>
        </div>
</div><!-- lContainer -->

<div class="clear"></div>
<script type="text/javascript">
$(document).ready(function () {
    var fp = <?php echo $display == 'block' ? 1 : 0; ?>;    
    if (fp) { 
        forgotPassword();
    }
});
function forgotPassword()
{
	$('#forgot_password').css('display','block');
	window.location.href += '#password_recovery';
}
//--></script>
