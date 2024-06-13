$(document).ready(function(){


    $('#EditPassWordShow').click(function(){
       
        if($('#EditPassWord').is(':hidden')){
            $('#EditPassWordShow').text('< اخفاء تعديل كلمة المرور');
            $('#EditPassWord').show();
            $('#EditPassWord').addClass('bounceIn animated');

        }else{
            $('#EditPassWordShow').text('> تعديل كلمة المرور');;
            $('#EditPassWord').hide();
        }

    })


    function UpdateAcount() {
        var token = $('#token').val();    
        var Bio = $('#BioP').val();
        var Email = $('#EmailP').val();

        if (Bio == '' || Email == '') {
            $.notify({
                title: '<strong></strong>',
                message: '<strong>الرجاء ملئ جميع الحقول المطلوبة</strong>'
            },{
                type: 'warning',
            });

            return;

        }



        $.ajax({
            url: '/include/api/pages/settings.php?action=UpdateAcount',
            type: 'POST',
            data: {
                token : token,
                Bio: Bio,
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
                    });
                    
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


    $('#UpdateAcount').click(function(){
    
        UpdateAcount();
       

    })




    function UpdateProfile () {
        
        var token = $('#token').val();
        var username = $('#usernameP').val();
        var First_Name = $('#First_Name').val();
        var Last_Name = $('#Last_Name').val();

        if (username == '' || First_Name == '' || Last_Name == '') {
            $.notify({
                title: '<strong></strong>',
                message: '<strong>الرجاء ملئ جميع الحقول المطلوبة</strong>'
            },{
                type: 'warning',
            });

            return;

        }


        $.ajax({
            url: '/include/api/pages/settings.php?action=UpdateProfile',
            type: 'POST',
            data: {
                token : token,
                username: username,
                First_Name: First_Name,
                Last_Name: Last_Name
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

                    $('#nameProfile').text(First_Name+' '+Last_Name);


                    
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

    $('#UpdateProfile').click(function(){
        UpdateProfile();
    });
   



    function UpdatePassword() {
        var token = $('#token').val();
        var OldPassword = $('#OldPassword').val();
        var NewPassword = $('#NewPassword').val();
        var ConfirmPassword = $('#ConfirmPassword').val();

        if (OldPassword == '' || NewPassword == '' || ConfirmPassword == '') {
            $.notify({
                title: '<strong></strong>',
                message: '<strong>الرجاء ملئ جميع الحقول المطلوبة</strong>'
            },{
                type: 'warning',
            });

            return;

        }

       

            $.ajax({
                url: '/include/api/pages/settings.php?action=UpdatePassword',
                type: 'POST',
                data: {
                    token : token,
                    OldPassword: OldPassword,
                    NewPassword: NewPassword,
                    ConfirmPassword: ConfirmPassword
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

                        $('#EditPassWord').hide();
                        $('#OldPassword').val('');
                        $('#NewPassword').val('');
                        $('#ConfirmPassword').val('');
                        $('#EditPassWordShow').text('> تعديل كلمة المرور');;

                        

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

    $('#UpdatePassword').click(function(){
        UpdatePassword();
    });




    $('#ProfileImage').click(function(){
        
        $('#UploadImage').modal('show');
        $('#UploadImage').addClass('bounceIn animated');



    });


    function UploadAvatar(){

        var token = $('#token').val();
        var file_data = $('#FileAvatar').prop('files')[0];

        if (file_data == null) {
            $.notify({
                title: '<strong></strong>',
                message: '<strong>الرجاء اختيار صورة</strong>'
            },{
                type: 'warning',
                z_index:200000

            });
            return;
        }



        var form_data = new FormData();
        form_data.append('Avatar', file_data);
        form_data.append('token', token);
        
       
        $.ajax({
            url: '/include/api/pages/settings.php?action=UploadAvatar',
            dataType: 'text',
            cache: false,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'POST',
            success: function(data){
                data = JSON.parse(data);
                if (data.status == 'success') {
                    $.notify({
                        title: '<strong></strong>',
                        message: '<strong>'+data.message+'</strong>'
                    },{
                        type: 'success',
                    });

                    setTimeout(function(){
                        window.location.reload();
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


    $('#UploadAvatar').click(function(){
        UploadAvatar();
    });

 


   
});
