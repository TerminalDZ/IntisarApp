/**
     *Edit User
        * - Genrate Password
        * - Show Password
        * - Edit User
        * - Edit User And Close
**/

$(document).ready(function(){

    function genratePassword () {
        var length = 8,
            charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789@#$&*\!?",
            password = "";
        for (var i = 0, n = charset.length; i < length; ++i) {
            password += charset.charAt(Math.floor(Math.random() * n));
        }
        return password;
    }

    $('#genratePassword').click(function(){
        $('#password').val(genratePassword());
        $('#confirmPassword').val($('#password').val());
    });


    function ShowPassword() {
        
        if($('#password').attr('type') == 'text'){
            $('#password').attr('type','password');
            $('#confirmPassword').attr('type','password');
            $('#IconShowPassword').removeClass('fa-eye-slash');
            $('#IconShowPassword').addClass('fa-eye');
            return;
        }else{
            $('#password').attr('type','text');
            $('#confirmPassword').attr('type','text');
            $('#IconShowPassword').removeClass('fa-eye');
            $('#IconShowPassword').addClass('fa-eye-slash');
            return;
        }
      
    }

    $('#ShowPassword').click(function(){
        ShowPassword();
    });



    function EditUser (Close=false) {
        var token = $('#token').val();
        var userId = $('#userId').val();
        var fr_name = $('#fr_name').val();
        var ls_name = $('#ls_name').val();
        var username = $('#username').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var confirmPassword = $('#confirmPassword').val();
        var access = $('#access').val();

        if(fr_name == '' || ls_name == '' || username == '' || email == '' || access == ''){
            $.notify({
                title: '<strong></strong>',
                message: '<strong>الرجاء ملئ جميع الحقول</strong>'
            },{
                type: 'danger',
            });
            return;
        }

        if(password != confirmPassword){
            $.notify({
                title: '<strong></strong>',
                message: '<strong>كلمة المرور غير متطابقة</strong>'
            },{
                type: 'danger',
            });
            return;
        }





        $.ajax({
            url: '/include/api/pages/users.php?action=editUser',
            type: 'POST',
            data: {
                token: token,
                userId: userId,
                fr_name: fr_name,
                ls_name: ls_name,
                username: username,
                email: email,
                password: password,
                confirmPassword: confirmPassword,
                access: access
            },
            success: function(data) {
                data = JSON.parse(data);
                if (data.status == 'success') {
                    $.notify({
                        title: '<strong></strong>',
                        message: '<strong>'+data.message+'</strong>'
                    },{
                        type: 'success',
                    });

                    $('#password').val('');
                    $('#confirmPassword').val('');

                    if(Close){
                        setTimeout(function(){
                            window.location.href = '/?p=users';
                        }, 1000);
                    }

                }else{
                    $.notify({
                        title: '<strong></strong>',
                        message: '<strong>'+data.message+'</strong>'
                    },{
                        type: 'danger',
                    });

                    $('#password').val('');
                    $('#confirmPassword').val('');
                }
            }
        });

    }


    $('#EditUser').click(function(){
        EditUser();
    });

    $('#EditUserAndClose').click(function(){
        EditUser(Close=true);
    });


});