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

      }


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


    $('#BtnLogin').click(function(){
        LoginSesion();
    });



});