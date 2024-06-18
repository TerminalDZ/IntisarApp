$(document).ready(function(){

    function LoginSesion() {

      var EmailOrUsername = $('#EmailOrUsername').val();
      var password = $('#password').val();
      var remember = $('#RememberMe').is(':checked');
      var token = $('#token').val();


      if (EmailOrUsername == '' || password == '') {
        $.notify({
          title: '<strong></strong>',
          message: '<strong>الرجاء ملئ جميع الحقول المطلوبة</strong>'
        },{
          type: 'warning',
        });

      }else{


        $.ajax({
          url: '/include/api/auth/login.php',
          type: 'POST',
          data: {
            token : token,
            EmailOrUsername: EmailOrUsername,
            password: password,
            remember: remember
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
              setTimeout(function(){
                window.location.href = '/';
              }, 1000);
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

      



    }


    $('#BtnLogin').click(function(){
        LoginSesion();
    });




    //Frogot Password
    function ForgotPassword() {
      var Email = $('#Email').val();
      var token = $('#token').val();

      if (Email == '') {
        $.notify({
          title: '<strong></strong>',
          message: '<strong>الرجاء ادخال البريد الالكتروني</strong>'
        },{
          type: 'warning',
        });
      }else{

        $.ajax({
          url: '/include/api/auth/forgot.php',
          type: 'POST',
          data: {
            token : token,
            Email: Email
          },
          success: function(data) {
            data = JSON.parse(data);
            if (data.status == 'success') {
              $.notify({
                title: '<strong></strong>',
                message: '<strong>'+data.message+'</strong>'
              },{
                type: 'success',

                z_index: 9999,
              });

              swal({
                title: "تم ارسال رابط استعادة كلمة المرور",
                text: "تم ارسال رابط استعادة كلمة المرور الى بريدك الالكتروني اذا لم تجده تأكد من البريد الغير مرغوب فيه (السبام) او اعادة ارسال الرابط مرة اخرى",
                icon: "success",
                button: "موافق",
              });

              setTimeout(function(){
                $('#Email').val('');
                window.location.href = '/';
              }, 3000);
              

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

    }

    $('#BtnForgot').click(function(){
      ForgotPassword();
    });


    function ResetPassword() {
      var password = $('#Password').val();
      var confirm_password = $('#ConfirmPassword').val();
      var token = $('#token').val();
      var TokenReset = $('#TokenReset').val();

      if (password == '' || confirm_password == '') {
        $.notify({
          title: '<strong></strong>',
          message: '<strong>الرجاء ملئ جميع الحقول المطلوبة</strong>'
        },{
          type: 'warning',
        });
      }else if (password != confirm_password) {
        $.notify({
          title: '<strong></strong>',
          message: '<strong>كلمة المرور غير متطابقة</strong>'
        },{
          type: 'warning',
        });
      }else{

       


        $.ajax({
          url: '/include/api/auth/reset.php',
          type: 'POST',
          data: {
            token : token,
            password: password,
            confirm_password: confirm_password,
            TokenReset: TokenReset
          },
          success: function(data) {
            data = JSON.parse(data);
            if (data.status == 'success') {
              $.notify({
                title: '<strong></strong>',
                message: '<strong>'+data.message+'</strong>'
              },{
                type: 'success',

                z_index: 9999,
              });

              swal({
                title: "تم تغيير كلمة المرور",
                text: "تم تغيير كلمة المرور بنجاح يمكنك الان تسجيل الدخول بكلمة المرور الجديدة",
                icon: "success",
                button: "موافق",
              });

              setTimeout(function(){
                $('#Password').val('');
                $('#ConfirmPassword').val('');
                window.location.href = '/';
              }, 1500);
              

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

    }

    $('#BtnReset').click(function(){
      ResetPassword();
    });


});