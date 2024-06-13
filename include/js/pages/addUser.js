/**
     * Add User
     * - Genrate Password
     * - Show Password
     * - Add User
     * - Add User And Close
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



    function AddUser(Close=false) {
        var token = $('#token').val();
        var fr_name = $('#fr_name').val();
        var ls_name = $('#ls_name').val();
        var username = $('#username').val();
        var email = $('#email').val();
        var password = $('#password').val();
        var confirmPassword = $('#confirmPassword').val();
        var access = $('#access').val();

        if(fr_name == '' || ls_name == '' || username == '' || email == '' || password == '' || confirmPassword == '' || access == ''){
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
            url: '/include/api/pages/users.php?action=addUser',
            type: 'POST',
            data: {
                token : token,
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
                    $('#fr_name').val('');
                    $('#ls_name').val('');
                    $('#username').val('');
                    $('#email').val('');
                    $('#password').val('');
                    $('#confirmPassword').val('');
                    $('#access').val('');

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
                }
            }
        });




    }


    $('#AddUser').click(function(){
        AddUser();
    });


    $('#AddUserAndClose').click(function(){
        AddUser(Close=true);
    });




});