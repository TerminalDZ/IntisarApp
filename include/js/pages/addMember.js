$(document).ready(function(){

    function member_id() {
        
        var member_id = Math.floor(Math.random() * 1000000);
        CheckMemberId(member_id);

        $('#member_id').val(member_id);



    }


    function CheckMemberId(member_id) {

        $.ajax({
            url: '/include/api/pages/addMember.php?action=member_id',
            type: "POST",
            data: {
                member_id: member_id
            },
            success: function (data) {
                data = JSON.parse(data);
                if (data.status == 'error') {
                    $.notify({
                        title: '<strong></strong>',
                        message: '<strong>' + data.message + '</strong>'
                    }, {
                        type: 'danger',
                    });

                    member_id();
                }
            }
        });
    }

    member_id();



    //family
    var checked = 0;

    function family() {
        $.ajax({
            url: '/include/api/pages/addMember.php?action=Getfamiles',
            type: "POST",
            success: function (data) {
                data = JSON.parse(data);
                if (data.status == 'success') {
                    $('#family_id').empty();
                    $('#family_id').append('<option value="">اختر الأسرة</option>');
                    data.data.forEach(function (family) {
                        $('#family_id').append('<option value="' + family.member_id + '">' + family.father_name + ' - ' + family.last_name + '</option>');
                    });

                } else {
                    $.notify({
                        title: '<strong></strong>',
                        message: '<strong>' + data.message + '</strong>'
                    }, {
                        type: 'danger',
                    });
                }
            }
        });
    }

    var value = [
        'father_name',
        'mother_name',
        'mother_last_name',
        'family_status',
        'caregiver',
        'living_condition',
        'guardian_id_number',
        'phone_number',
        'address',
        'job_father',
        'job_mother',
        
      
    ];


    function apply_data(member_id) {
        $.ajax({
            url: '/include/api/pages/addMember.php?action=GetMemberById',
            type: "POST",
            data: {
                member_id: member_id
            },
            success: function (data) {
                data = JSON.parse(data);
                if (data.status == 'success') {

                    $.notify({
                        title: '<strong></strong>',
                        message: '<strong>' + data.message + '</strong>'
                    }, {
                        type: 'success',
                    });

                    if(data.data['family_status'] == 'وفاة كلا الوالدين' || data.data['family_status'] == 'مطلقان' || data.data['family_status'] == 'وفاة الأب'){
                        $('#caregiver_div').show();
                        $('#caregiver').attr('required', 'required');
                    }else{
                        $('#caregiver_div').hide();
                        $('#caregiver').removeAttr('required');
                    }
                        


                    value.forEach(function (val) {
                        $('#' + val).val(data.data[val]);
                    });

                } else {
                    $.notify({
                        title: '<strong></strong>',
                        message: '<strong>' + data.message + '</strong>'
                    }, {
                        type: 'danger',
                    });
                }
            }
        });
    }

    $('#family_id').on('change', function() {

        if($(this).val() == ''){
            value.forEach(function (val) {
                $('#' + val).val('');
            });
            return;
        }

        var member_id = $(this).val();
        apply_data(member_id);
    });

    

    $('#has_been_entered_yes').on('change', function() {
        if ($(this).is(':checked')) {
            $('#family_id_div').show();
            $('#family_id').attr('required', 'required');
            if(checked == 0){
                family();
                checked = 1;
            }
        }else{
            $('#family_id_div').hide();
            $('#family_id').removeAttr('required');
            $('#family_id').val('');
            value.forEach(function (val) {
                $('#' + val).val('');
            });
        }
    });



    //picture
    $('#openCameraButton').on('click', function() {
        $('#camera').show();
        $('#capturedImageContainer').hide();
        Webcam.set({
            width: 320,
            height: 240,
            image_format: 'jpeg',
            jpeg_quality: 90,
        });
        Webcam.attach('#my_camera');
    });

    $('#takePictureButton').on('click', function() {
        var shutter = new Audio();
		shutter.autoplay = false;
		shutter.src = 'assets/audio/shutter.mp3';
        shutter.play();

        Webcam.snap(function(data_uri) {
            $('#camera').hide();
            Webcam.reset();
            var name = Math.floor(Math.random() * 1000000); 

            fetch(data_uri)
                .then(res => res.blob())
                .then(blob => {
                    const file = new File([blob], name + '.jpeg', { type: 'image/jpeg' });
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    $('#picture')[0].files = dataTransfer.files;

                    $('#capturedImage').attr('src', data_uri);
                    $('#capturedImageContainer').show();
                });
        });
    });

  
    


    $('#retakePictureButton').on('click', function() {
        $('#capturedImageContainer').hide();
        $('#camera').show();
        Webcam.attach('#my_camera');
    });

    $('#deletePictureButton').on('click', function() {
        $('#capturedImageContainer').hide();
        $('#picture').val('');
    });




    //family_status

    function family_status(){
        var family_status = $('#family_status').val();

        if(family_status == 'وفاة كلا الوالدين'){
            $('#caregiver_div').show();
            $('#caregiver').attr('required', 'required');
        }else if(family_status == 'مطلقان'){
            $('#caregiver_div').show();
            $('#caregiver').attr('required', 'required');
        }else if(family_status == 'وفاة الأب'){
            $('#caregiver_div').show();
            $('#caregiver').attr('required', 'required');
        }else{
            $('#caregiver_div').hide();
            $('#caregiver').removeAttr('required');
            $('#caregiver').val('');
        }

    }

    $('#family_status').on('change', function(){
        family_status();
    });


  


    //scout_unit


    function scout_unit(){
        var dob = $('#dob').val();
        var gender = $('#gender').val();

        var dob = new Date(dob);
        var today = new Date();
        var age = today.getFullYear() - dob.getFullYear();
        var m = today.getMonth() - dob.getMonth();
        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        if(gender == 'ذكر'){
            $('#scout_unit option[value="زهرات"]').prop('disabled', true);
            $('#scout_unit option[value="مرشدات"]').prop('disabled', true);
            $('#scout_unit option[value="دليلات"]').prop('disabled', true);

            $('#scout_unit option[value="أشبال"]').prop('disabled', false);
            $('#scout_unit option[value="كشاف"]').prop('disabled', false);
            $('#scout_unit option[value="جوال"]').prop('disabled', false);
        }else{
            $('#scout_unit option[value="أشبال"]').prop('disabled', true);
            $('#scout_unit option[value="كشاف"]').prop('disabled', true);
            $('#scout_unit option[value="جوال"]').prop('disabled', true);

            $('#scout_unit option[value="زهرات"]').prop('disabled', false);
            $('#scout_unit option[value="مرشدات"]').prop('disabled', false);
            $('#scout_unit option[value="دليلات"]').prop('disabled', false);


        }
            


        if(age >= 3 && age <= 9){
            if(gender == 'ذكر'){
                $('#scout_unit').val('أشبال');
            }else{
                $('#scout_unit').val('زهرات');
            }
        }else if(age >= 10 && age <= 14){
            if(gender == 'ذكر'){
                $('#scout_unit').val('كشاف');
            }else{
                $('#scout_unit').val('دليلات');
            }
        }else if(age >= 15 && age <= 17){
            if(gender == 'ذكر'){
                $('#scout_unit').val('جوال');
            }else{
                $('#scout_unit').val('مرشدات');
            }
        }else if(age >= 18 && age <= 99){
                $('#scout_unit').val('قائد');
        }


    }

    $('#dob').on('change', function(){
        scout_unit();
    });

    $('#gender').on('change', function(){
        scout_unit();
    });



    //prepare form data
    function prepareFormData() {
        var token = $('#token').val();

        //Member data

        var member_id = $('#member_id').val();
        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var gender = $('#gender').val();
        var dob = $('#dob').val();
        var place_of_increase = $('#place_of_increase').val();
        var father_name = $('#father_name').val();
        var mother_name = $('#mother_name').val();
        var mother_last_name = $('#mother_last_name').val();
        var job_father = $('#job_father').val();
        var job_mother = $('#job_mother').val();
        var family_status = $('#family_status').val();
        var caregiver = $('#caregiver').val();
        var living_condition = $('#living_condition').val();
        var chronic_diseases = $('#chronic_diseases').val();
        var hobbies = $('#hobbies').val();
        var sport = $('#sport').val();
        var educational_institution = $('#educational_institution').val();
        var joining_date = $('#joining_date').val();
        

        //Contact Data

        var guardian_id_number = $('#guardian_id_number').val();
        var phone_number = $('#phone_number').val();
        var address = $('#address').val();

   
        //Scouting data

        var has_scout_uniform = $('#has_scout_uniform').val();
        var scout_uniform_size = $('#scout_uniform_size').val();
        var scout_uniform_payer = $('#scout_uniform_payer').val();
        var scout_unit = $('#scout_unit').val();

        //Picture
        var picture = $('#picture')[0].files[0];

        //return data

        var formData = new FormData();
        formData.append('token', token);
        formData.append('member_id', member_id);
        formData.append('first_name', first_name);
        formData.append('last_name', last_name);
        formData.append('gender',gender);
        formData.append('dob', dob);
        formData.append('place_of_increase', place_of_increase);
        formData.append('father_name', father_name);
        formData.append('mother_name', mother_name);
        formData.append('mother_last_name', mother_last_name);
        formData.append('job_father', job_father);
        formData.append('job_mother', job_mother);
        formData.append('family_status', family_status);
        formData.append('caregiver', caregiver);
        formData.append('living_condition', living_condition);
        formData.append('chronic_diseases', chronic_diseases);
        formData.append('hobbies', hobbies);
        formData.append('sport', sport);
        formData.append('educational_institution', educational_institution);
        formData.append('guardian_id_number', guardian_id_number);
        formData.append('phone_number', phone_number);
        formData.append('address', address);

        formData.append('has_scout_uniform', has_scout_uniform);
        formData.append('scout_uniform_size', scout_uniform_size);
        formData.append('scout_uniform_payer', scout_uniform_payer);
        formData.append('scout_unit', scout_unit);
        formData.append('picture', picture);
        formData.append('joining_date', joining_date);

        return formData;

    }

    //notfiy function
    function notify(title, message, type) {
        $.notify({
            title: '<strong>' + title + '</strong>',
            message: '<strong>' + message + '</strong>'
        }, {
            type: type,
        });
    }

    //Check if form is valid
    function isFormValid() {
        var validate = true;
        var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var gender = $('#gender').val();
        var dob = $('#dob').val();
        var place_of_increase = $('#place_of_increase').val();
        var father_name = $('#father_name').val();
        var mother_name = $('#mother_name').val();
        var job_father = $('#job_father').val();
        var job_mother = $('#job_mother').val();
        var mother_last_name = $('#mother_last_name').val();
        var family_status = $('#family_status').val();
        var caregiver = $('#caregiver').val();
        var living_condition = $('#living_condition').val();
        //Contact Data
        var guardian_id_number = $('#guardian_id_number').val();
        var phone_number = $('#phone_number').val();
        var address = $('#address').val();
       
        //Scouting data
        var has_scout_uniform = $('#has_scout_uniform').val();
        var scout_uniform_payer = $('#scout_uniform_payer').val();
        var scout_unit = $('#scout_unit').val();

        var joining_date = $('#joining_date').val();



        if (first_name == '') {
            validate = false;
            $('#first_name').addClass('is-invalid');
            notify('خطأ', 'الرجاء إدخال الاسم الأول', 'danger');
            return false;
        } else {
            $('#first_name').removeClass('is-invalid');
        }

        if (last_name == '') {
            validate = false;
            $('#last_name').addClass('is-invalid');
            notify('خطأ', 'الرجاء إدخال الاسم الأخير', 'danger');
            return false;
        }else {
            $('#last_name').removeClass('is-invalid');
        }

        
        if (gender == '') {
            validate = false;
            $('#gender').addClass('is-invalid');
            notify('خطأ', 'الرجاء إدخال الجنس', 'danger');
            return false;
        }else {
            $('#gender').removeClass('is-invalid');
        }

        if (dob == '') {
            validate = false;
            $('#dob').addClass('is-invalid');
            notify('خطأ', 'الرجاء إدخال تاريخ الميلاد', 'danger');
            return false;
        }else {
            $('#dob').removeClass('is-invalid');
        }

        if (place_of_increase == '') {
            validate = false;
            $('#place_of_increase').addClass('is-invalid');
            notify('خطأ', 'الرجاء إدخال مكان الازدياد', 'danger');
            return false;
        }else {
            $('#place_of_increase').removeClass('is-invalid');
        }

        if (father_name == '') {
            validate = false;
            $('#father_name').addClass('is-invalid');
            notify('خطأ', 'الرجاء إدخال اسم الأب', 'danger');
            return false;
        }else {
            $('#father_name').removeClass('is-invalid');
        }

        if (mother_name == '') {
            validate = false;
            $('#mother_name').addClass('is-invalid');
            notify('خطأ', 'الرجاء إدخال اسم الأم', 'danger');
            return false;
        }else {
            $('#mother_name').removeClass('is-invalid');
        }

        if (mother_last_name == '') {
            validate = false;
            $('#mother_last_name').addClass('is-invalid');
            notify('خطأ', 'الرجاء إدخال اسم العائلة للأم', 'danger');
            return false;
        }else {
            $('#mother_last_name').removeClass('is-invalid');
        }

        if (job_father == '') {
            validate = false;
            $('#job_father').addClass('is-invalid');
            notify('خطأ', 'الرجاء إدخال مهنة الأب', 'danger');
            return false;
        }else {
            $('#job_father').removeClass('is-invalid');
        }

        if (job_mother == '') {
            validate = false;
            $('#job_mother').addClass('is-invalid');
            notify('خطأ', 'الرجاء إدخال مهنة الأم', 'danger');
            return false;
        }else {
            $('#job_mother').removeClass('is-invalid');
        }



        if (family_status == '') {
            validate = false;
            $('#family_status').addClass('is-invalid');
            notify('خطأ', 'الرجاء إدخال حالة الأسرة', 'danger');
            return false;
        }else {
            $('#family_status').removeClass('is-invalid');
        }


        if (family_status == 'وفاة كلا الوالدين' || family_status == 'مطلقان' || family_status == 'وفاة الأب') { 
            if (caregiver == '' ) {
                validate = false;
                $('#caregiver').addClass('is-invalid');
                notify('خطأ', 'الرجاء إدخال اسم المعيل', 'danger');
                return false;
            }else {
                $('#caregiver').removeClass('is-invalid');
            }
        }

        if (living_condition == '') {
            validate = false;
            $('#living_condition').addClass('is-invalid');
            notify('خطأ', 'الرجاء إدخال ظروف السكن', 'danger');
            return false;
        }else {
            $('#living_condition').removeClass('is-invalid');
        }


        //Contact Data

        if (guardian_id_number == '') {
            validate = false;
            $('#guardian_id_number').addClass('is-invalid');
            notify('خطأ', 'الرجاء إدخال رقم الهوية', 'danger');
            return false;
        }else {
            $('#guardian_id_number').removeClass('is-invalid');
        }

        if (phone_number == '') {
            validate = false;
            $('#phone_number').addClass('is-invalid');
            notify('خطأ', 'الرجاء إدخال رقم الهاتف', 'danger');
            return false;
        }else {
            $('#phone_number').removeClass('is-invalid');
        }

        if (address == '') {
            validate = false;
            $('#address').addClass('is-invalid');
            notify('خطأ', 'الرجاء إدخال العنوان', 'danger');
            return false;
        }else {
            $('#address').removeClass('is-invalid');
        }


       

        //Scouting data

        if (has_scout_uniform == '') {
            validate = false;
            $('#has_scout_uniform').addClass('is-invalid');
            notify('خطأ', 'الرجاء إدخال توفر الزي الكشفي', 'danger');
            return false;
        }else {
            $('#has_scout_uniform').removeClass('is-invalid');
        }


        if (scout_uniform_payer == '') {
            validate = false;
            $('#scout_uniform_payer').addClass('is-invalid');
            notify('خطأ', 'الرجاء إدخال هل منخرط دافع ثمن الزي الكشفي ', 'danger');
            return false;
        }else {
            $('#scout_uniform_payer').removeClass('is-invalid');
        }

        if (scout_unit == '') {
            validate = false;
            $('#scout_unit').addClass('is-invalid');
            notify('خطأ', 'الرجاء إدخال الوحدة الكشفية', 'danger');
            return false;
        }else {
            $('#scout_unit').removeClass('is-invalid');
        }

        if (joining_date == '') {
            validate = false;
            $('#joining_date').addClass('is-invalid');
            notify('خطأ', 'الرجاء إدخال تاريخ الانضمام', 'danger');
            return false;
        }else {
            $('#joining_date').removeClass('is-invalid');
        }


        return validate;

    }


    //submit form

    function submitForm(Close = false) {
        var formData = prepareFormData();

        $.ajax({
            url: '/include/api/pages/addMember.php?action=AddMember',
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (data) {
                data = JSON.parse(data);
                if (data.status == 'success') {
                    $.notify({
                        title: '<strong></strong>',
                        message: '<strong>' + data.message + '</strong>'
                    }, {
                        type: 'success',
                    });
                    $('#addMemberForm')[0].reset();
                    $('#capturedImageContainer').hide();
                    $('#picture').val('');
                    member_id();

                    if (Close) {
                        setTimeout(function () {
                            window.location.href = '/?p=members';
                        }, 1000);
                    }


                } else {
                    $.notify({
                        title: '<strong></strong>',
                        message: '<strong>' + data.message + '</strong>'
                    }, {
                        type: 'danger',
                    });
                }
            }
        });
    }


    $('#AddMember').click(function (e) {
        e.preventDefault();
        if (isFormValid()) {
            submitForm();
        }
    });

    $('#AddMemberAndClose').click(function (e) {
        e.preventDefault();
        if (isFormValid()) {
            submitForm(Close = true);
        }
    });






});