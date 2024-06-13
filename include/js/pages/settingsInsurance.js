$(document).ready(function(){

    var value = [
        'amount_cubs',
        'amount_sprouts',
        'amount_scouts',
        'amount_dalilat',
        'amount_guides',
        'amount_rangers',
        'amount_leaders',
        'amount_masters',
    ]

    function CheckValue() {
       //check  the value is not empty and not less than 0
        for (var i = 0; i < value.length; i++) {
            if ($('#' + value[i]).val() == '' || $('#' + value[i]).val() < 0) {
                $.notify({
                    title: '<strong></strong>',
                    message: '<strong>الرجاء التأكد من ادخال قيم صحيحة</strong>'
                },{
                    type: 'warning',
                });
                $('#' + value[i]).addClass('is-invalid');


                return false;
            }else{
                $('#' + value[i]).removeClass('is-invalid');
            }
        }
        return true;



    }

   function saveSettingsInsurance() {
        var token = $('#token').val();
        var form = new FormData();
        form.append('token', token);
        for (var i = 0; i < value.length; i++) {
            form.append(value[i], $('#' + value[i]).val());
        }


        if (!CheckValue()) {
            return;
        }

        $.ajax({
            url: '/include/api/pages/settingsInsurance.php?action=saveSettingsInsurance',
            type: 'POST',
            data: form,
            processData: false,
            contentType: false,
            success: function(data) {
                var response = JSON.parse(data);
                if (response.error) {
                    $.notify({
                        title: '<strong></strong>',
                        message: '<strong>' + response.message + '</strong>'
                    },{
                        type: 'danger',
                    });
                } else {
                    $.notify({
                        title: '<strong></strong>',
                        message: '<strong>' + response.message + '</strong>'
                    },{
                        type: 'success',
                    });
                }
            }
        });

   }

    $('#saveSettingsInsurance').click(function() {
        saveSettingsInsurance();
    });


   




});