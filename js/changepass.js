$(document).ready(()=>{
    changePassword();
    togglePassword();
});
function changePassword(){
    $("#btn-change-password").click(()=>{
        $.post('../handlers/userHandler.php', $("#change-password-form").serialize(), (data)=>{
            $("#change-password-modal").modal('hide');
            if(data > 0){ 
                feedbackModal('1', "Password changed successfully", "Password change failed", 0);
            }else{
                feedbackModal('0', "Password changed successfully", "Password change failed", 0);
            }
        });
    });
}

function togglePassword(){
    $(".toggle-password").on('click', function(){
        if($($(this).attr('for')).attr('type') == 'password'){
            $($(this).attr('for')).attr('type','text');
            $('a[for="'+$(this).attr('for')+'"] > .bi-eye-slash').hide();
            $('a[for="'+$(this).attr('for')+'"] > .bi-eye').show();
        }else{
            $($(this).attr('for')).attr('type','password');
            $('a[for="'+$(this).attr('for')+'"] > .bi-eye-slash').show();
            $('a[for="'+$(this).attr('for')+'"] > .bi-eye').hide();
        }
    });
}